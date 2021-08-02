<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 * @ApiResource(
 *  itemOperations = {
 *      "put",
 *      "delete",
 *      "get" = {
 *          "normalization_context"={"groups"="read:invoice:item"}
 *      }
 *  },
 *  collectionOperations = {
 *      "post",
 *      "get" = {
 *          "normalization_context"={"groups"="read:invoice:collection"}
 *      }
 *  }
 * )
 * @ApiFilter(DateFilter::class, properties={"sendingAt"})
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:customer:item","read:invoice:collection","read:invoice:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read:customer:item","read:invoice:collection","read:invoice:item"})
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read:customer:item","read:invoice:collection","read:invoice:item"})
     */
    private $sendingAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:customer:item","read:invoice:collection","read:invoice:item"})
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="invoices")
     * @Groups({"read:invoice:collection","read:invoice:item"})
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSendingAt(): ?\DateTimeInterface
    {
        return $this->sendingAt;
    }

    public function setSendingAt(?\DateTimeInterface $sendingAt): self
    {
        $this->sendingAt = $sendingAt;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
