<?php

class X
{
    /**
     * @var Collection<Value>|Value[]
     * @ORM\ManyToMany(
     *  targetEntity="\Dl\Component\DomainModel\Product\Value\AbstractValue",
     *  inversedBy="externalAliases"
     * )
     */
    private $values;
}
