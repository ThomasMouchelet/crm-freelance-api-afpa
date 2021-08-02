<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @ApiResource(
 *  itemOperations = {
 *      "put",
 *      "delete",
 *      "GET" = {
 *          "normalization_context"={"groups"="read:customer:item"}
 *      }
 *  },
 *  collectionOperations = {
 *      "post",
 *      "GET" = {
 *          "normalization_context"={"groups"="read:customer:collection"}
 *      }
 *  }
 * )
 * @ApiFilter(SearchFilter::class, properties={"companyName","firstName","lastName"})
 */

class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({
     *  "read:customer:item",
     *  "read:customer:collection",
     *  "read:invoice:collection",
     *  "read:invoice:item"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     * "read:customer:item",
     * "read:invoice:item"
     * }) 
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     * "read:customer:item",
     * "read:invoice:item"
     * })
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     * "read:customer:item",
     * "read:customer:collection",
     * "read:invoice:collection",
     * "read:invoice:item"
     * })
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     * "read:customer:item",
     * "read:customer:collection",
     * "read:invoice:collection",
     * "read:invoice:item"
     * })
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({
     * "read:customer:item",
     * "read:customer:collection",
     * "read:invoice:collection",
     * "read:invoice:item"
     * })
     */
    private $companyName;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="customer", cascade={"remove"})
     * @Groups({
     * "read:customer:item",
     * "read:customer:collection",
     * })
     */
    private $invoices;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setCustomer($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCustomer() === $this) {
                $invoice->setCustomer(null);
            }
        }

        return $this;
    }
}
