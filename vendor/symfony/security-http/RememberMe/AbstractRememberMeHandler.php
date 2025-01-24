<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Security\Http\RememberMe;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
abstract class AbstractRememberMeHandler implements RememberMeHandlerInterface
{
    protected array $options;

    public function __construct(
        private UserProviderInterface $userProvider,
        protected RequestStack $requestStack,
        array $options = [],
        protected ?LoggerInterface $logger = null,
    ) {
        $this->options = $options + [
            'name' => 'REMEMBERME',
            'lifetime' => 31536000,
            'path' => '/',
            'domain' => null,
            'secure' => false,
            'httponly' => true,
            'samesite' => null,
            'always_remember_me' => false,
            'remember_me_parameter' => '_remember_me',
        ];
    }

    /**
     * Checks if the RememberMeDetails is a valid cookie to login the given SymfonyUser.
     *
     * This method should also:
     * - Create a new remember-me cookie to be sent with the response (using {@see createCookie()});
     * - If you store the token somewhere else (e.g. in a database), invalidate the stored token.
     *
     * @throws AuthenticationException If the remember-me details are not accepted
     */
    abstract protected function processRememberMe(RememberMeDetails $rememberMeDetails, UserInterface $user): void;

    public function consumeRememberMeCookie(RememberMeDetails $rememberMeDetails): UserInterface
    {
        $user = $this->userProvider->loadUserByIdentifier($rememberMeDetails->getUserIdentifier());
        $this->processRememberMe($rememberMeDetails, $user);

        $this->logger?->info('Remember-me cookie accepted.');

        return $user;
    }

    public function clearRememberMeCookie(): void
    {
        $this->logger?->debug('Clearing remember-me cookie.', ['name' => $this->options['name']]);

        $this->createCookie(null);
    }

    /**
     * Creates the remember-me cookie using the correct configuration.
     *
     * @param RememberMeDetails|null $rememberMeDetails The details for the cookie, or null to clear the remember-me cookie
     */
    protected function createCookie(?RememberMeDetails $rememberMeDetails): void
    {
        $request = $this->requestStack->getMainRequest();
        if (!$request) {
            throw new \LogicException('Cannot create the remember-me cookie; no master request available.');
        }

        // the ResponseListener configures the cookie saved in this attribute on the final response object
        $request->attributes->set(ResponseListener::COOKIE_ATTR_NAME, new Cookie(
            $this->options['name'],
            $rememberMeDetails?->toString(),
            $rememberMeDetails?->getExpires() ?? 1,
            $this->options['path'],
            $this->options['domain'],
            $this->options['secure'] ?? $request->isSecure(),
            $this->options['httponly'],
            false,
            $this->options['samesite']
        ));
    }
}
