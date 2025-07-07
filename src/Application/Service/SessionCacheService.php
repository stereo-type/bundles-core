<?php

/**
 * @copyright  2025 Zhalayletdinov Vyacheslav evil_tut@mail.ru
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace AcademCity\CoreBundle\Application\Service;

use AcademCity\CoreBundle\Application\Enum\SessionCacheKeys;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Cache\CacheInterface;

readonly class SessionCacheService
{
    public function __construct(
        private CacheInterface $cache,
        private RequestStack $requestStack,
        private Security $security,
    ) {
    }

    /**
     * Получает данные из кеша для текущей сессии.
     *
     * @param SessionCacheKeys|string $key Тип кеша
     * @param callable $callback Функция для получения данных, если кеш пуст
     *
     * @return mixed Данные из кеша или результат callback
     *
     * @throws InvalidArgumentException
     */
    public function getData(SessionCacheKeys|string $key, callable $callback): mixed
    {
        try {
            $session = $this->getSession();
            $sessionId = $session->getId();
            $cacheKey = $this->buildCacheKey($key, $sessionId);
            return $this->cache->get($cacheKey, function (CacheItemInterface $item) use ($callback, $key, $cacheKey) {
                $data = $callback();

                // Устанавливаем значение в кеш
                $item->set($data);

                // Добавляем ключ в метакеш
                $this->addKeyToMetaCache($key, $cacheKey);

                return $data;
            });
        } catch (SessionNotFoundException) {
            return $callback();
        }
    }

    /**
     * Удаляет все кеши для заданного типа ключа (первый уровень).
     *
     * @param SessionCacheKeys|string $key Тип кеша
     *
     * @throws InvalidArgumentException
     */
    public function purgeAllCachesForType(SessionCacheKeys|string $key): void
    {
        $metaKey = $this->buildMetaCacheKey($key);

        // Получаем список всех ключей для данного типа
        $keys = $this->listKeys($key);

        if (!empty($keys)) {
            foreach ($keys as $cacheKey) {
                $this->cache->delete($cacheKey);
            }
        }

        // Очищаем метакеш
        $this->cache->delete($metaKey);
    }

    /**
     * Возвращает список всех ключей для заданного типа кеша.
     *
     * @param SessionCacheKeys|string $key Тип кеша
     *
     * @return array Список ключей
     *
     * @throws InvalidArgumentException
     */
    public function listKeys(SessionCacheKeys|string $key): array
    {
        $metaKey = $this->buildMetaCacheKey($key);

        // Получаем список всех ключей из метакеша
        return $this->cache->get($metaKey, function () {
            return [];
        });
    }

    /**
     * Строит полный ключ для кеша на основе типа ключа и идентификатора сессии.
     */
    private function buildCacheKey(SessionCacheKeys|string $key, string $sessionId): string
    {
        $userId = $this->getCurrentUserId();

        return sprintf('type_key:%s:user:%d:session_%s', is_string($key) ? $key : $key->value, $userId, $sessionId);
    }

    /**
     * Строит ключ для метакеша.
     */
    private function buildMetaCacheKey(SessionCacheKeys|string $key): string
    {
        return sprintf('meta_key:%s', is_string($key) ? $key : $key->value);
    }

    /**
     * Добавляет ключ в метакеш.
     *
     * @throws InvalidArgumentException
     */
    private function addKeyToMetaCache(SessionCacheKeys|string $key, string $cacheKey): void
    {
        $metaKey = $this->buildMetaCacheKey($key);

        // Получаем текущий список ключей из метакеша
        $keys = $this->listKeys($key);

        // Добавляем новый ключ, если его еще нет в списке
        if (!in_array($cacheKey, $keys, true)) {
            $keys[] = $cacheKey;
            /**Дропаем и перезаписываем*/
            $this->cache->delete($metaKey);
            $this->cache->get($metaKey, function () use ($keys) {
                return $keys;
            });
        }
    }

    /**
     * Получает ID текущего пользователя.
     *
     * @throws \LogicException Если пользователь не аутентифицирован или не имеет ID
     */
    private function getCurrentUserId(): int
    {
        $user = $this->security->getUser();
        if (!$user || !method_exists($user, 'getId')) {
            return 0;
            //            throw new \LogicException('User is not authenticated or does not have an ID.');
        }

        return $user->getId();
    }

    /**
     * Получает текущую сессию.
     *
     * @throws SessionNotFoundException Если сессия не найдена
     */
    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
