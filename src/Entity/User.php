<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Le champ email ne peut pas être vide !")
     * @ORM\Column(type="string", length=180, unique=true)
     */

    private $pseudo;

    /**
     * @Assert\NotBlank(message="Le champ pseudo ne peut pas être vide !")
     * @return mixed
     */


    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @var string
     * @Assert\NotBlank(message="Le champ mot de passe ne peut pas être vide !")
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @SecurityAssert\UserPassword(
     *     message = "USER_OLD_PASSWORD_INVALID_DATA",
     *     groups={"password"}
     * )
     */
    protected $oldPassword;


    public function __construct()
    {
        // Roles des utilisateurs
        $this->roles = ['ROLE_USER'];

    }




    public function getPseudo()
    {
        return $this->pseudo;
    }



    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $roles = $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }


    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
    /**
     * @param string $plainPassword
     */
    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
    /**
     * @return string
     */
    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     */
    public function setOldPassword(string $oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }














}

