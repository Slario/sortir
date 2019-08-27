<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as UserBase;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User extends UserBase
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $tel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="organisateur")
     */
    private $orgaSortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inscription", inversedBy="participant")
     */
    private $inscris;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="participant")
     */
    private $inscriptions;


    public function __construct()
    {
        parent::__construct();
        $this->orgaSortie = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();

        // your own logic
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

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
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

    public function getInscris(): ?Inscription
    {
        return $this->inscris;
    }

    public function setInscris(?Inscription $inscris): self
    {
        $this->inscris = $inscris;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
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

}

