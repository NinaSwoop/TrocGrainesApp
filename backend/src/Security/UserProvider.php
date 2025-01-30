<?php

namespace App\Security;

use App\Domain\Model\User;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Psr\Log\LoggerInterface;


class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private UserRepositoryInterface $userRepository;
    private LoggerInterface $logger;

    public function __construct(UserRepositoryInterface $userRepository, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me.
     *
     * If you're not using these features, you do not need to implement
     * this method.
     *
     * @throws UserNotFoundException if the user is not found
     */
    public function loadUserByIdentifier($identifier): UserInterface
    {
        $domainUser = $this->userRepository->findByEmail($identifier);

        if (!$domainUser) {
            $this->logger->error(sprintf('Utilisateur non trouvé pour identifiant : %s', $identifier));
            throw new UserNotFoundException(sprintf('Utilisateur avec l\'identifiant "%s" non trouvé.', $identifier));
        }

        return new SecurityUser($domainUser);
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SecurityUser) {
            $this->logger->error(sprintf('Instances of "%s" are not supported.', get_class($user)));
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        $domainUser = $this->userRepository->findByEmail($user->getUserIdentifier());

        if (!$domainUser) {
            $this->logger->error(sprintf('Utilisateur avec l\'identifiant "%s" non trouvé.', $user->getUserIdentifier()));
            throw new UserNotFoundException(sprintf('Utilisateur avec l\'identifiant "%s" non trouvé.', $user->getUserIdentifier()));
        }

        return new SecurityUser($domainUser);
    }

    /**
     * Tells Symfony to use this provider for this User class.
     */
    public function supportsClass(string $class): bool
    {
        return SecurityUser::class === $class || is_subclass_of($class, SecurityUser::class);
    }

    /**
     * Upgrades the hashed password of a user, typically for using a better hash algorithm.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof SecurityUser) {
            $this->logger->error(sprintf('Classe utilisateur non prise en charge pour mise à jour de mot de passe : "%s".', get_class($user)));
            throw new UnsupportedUserException(sprintf('Classe utilisateur non prise en charge pour mise à jour de mot de passe : "%s".', get_class($user)));
        }

        $updatedUser = new User(
            id: $user->getUser()->id(),
            username: $user->getUser()->username(),
            firstname: $user->getUser()->firstname(),
            lastname: $user->getUser()->lastname(),
            email: $user->getUser()->email(),
            birthdate: $user->getUser()->birthdate(),
            picture: $user->getUser()->picture(),
            password: $newHashedPassword,
            pointBalance: $user->getUser()->pointBalance(),
            roles: $user->getUser()->roles(),
            createdAt: $user->getUser()->createdAt(),
            updatedAt: new \DateTimeImmutable()
        );

        $this->userRepository->update($updatedUser);
    }
}
