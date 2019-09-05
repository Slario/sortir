<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 *
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
     * @Assert\NotBlank(message="Le champ email ne peut pas être vide !")
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Le champ pseudo ne peut pas être vide !")
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank()
     */

    private $pseudo;

    /**
     * @ORM\Column(type="array")
     *
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=200)
     */
    private $password;


    /**
     * @var string
     * @Assert\NotBlank(message="Le champ mot de passe ne peut pas être vide !")
     * @Assert\Length(min=8)
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

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telephone;


    /**
     * @var string
     * @ORM\Column(name="img", type="string", nullable=true)
     * @Assert\File(
     *     mimeTypes={"image/png" ,"image/jpg","image/jpeg"},
     *     mimeTypesMessage = "Svp inserer une image valide (png,jpg,jpeg)")
     */
    private $img;

    /**
     * @ORM\Column(type="binary")
     *
     */
    private $actif;

    /**
     * @ManyToOne(targetEntity="App\Entity\Site", inversedBy="users")
     * @JoinColumn(name="site_id", referencedColumnName="id")
     */
    private $site;

    /**
     * @OneToMany(targetEntity="App\Entity\Inscription", mappedBy="participant")
     */
    private $inscriptions;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="organisateur", orphanRemoval=true)
     */
    private $orgaSortie;


    public function __construct()
    {
        // Roles des utilisateurs
        $this->roles = ['ROLE_USER'];
        $this->actif = 1;
        $this->inscriptions = new ArrayCollection();
        $this->orgaSortie = new ArrayCollection();

    }

    /**
     * @return mixed
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
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
        return (string)$this->email;
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
        return (string)$this->password;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getActif()
    {
        return $this->actif;
    }

    public function setActif($actif): self
    {
        $this->actif = $actif;

        return $this;
    }


    /**
     * @return string
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }


    public function __toString(): ?string
    {

        $sb = $this->getPrenom() . " " . $this->getNom();

        return $sb;

    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setParticipant($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->contains($inscription)) {
            $this->inscriptions->removeElement($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getParticipant() === $this) {
                $inscription->setParticipant(null);
            }
        }

        return $this;
    }


    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getOrgaSortie(): Collection
    {
        return $this->orgaSortie;
    }

    public function addOrgaSortie(Sortie $orgaSortie): self
    {
        if (!$this->orgaSortie->contains($orgaSortie)) {
            $this->orgaSortie[] = $orgaSortie;
            $orgaSortie->setOrganisateur($this);
        }

        return $this;
    }

    public function removeOrgaSortie(Sortie $orgaSortie): self
    {
        if ($this->orgaSortie->contains($orgaSortie)) {
            $this->orgaSortie->removeElement($orgaSortie);
            // set the owning side to null (unless already changed)
            if ($orgaSortie->getOrganisateur() === $this) {
                $orgaSortie->setOrganisateur(null);
            }
        }

        return $this;
    }
}
