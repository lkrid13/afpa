<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class PropertySearch
{

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     */
    private $minSurface;
    
    /**
     *
     * @var ArrayCollection
     */
    private $options;

    function __construct() {
        $this->options = new ArrayCollection();
    }

    /**
     * 
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * 
     * @param int $maxPrice
     * @return \self
     */
    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * 
     * @return int|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * 
     * @param int $minSurface
     * @return \self
     */
    public function setMinSurface(int $minSurface): self
    {
        $this->minSurface = $minSurface;

        return $this;
    }
    
    /**
     * 
     * @return ArrayCollection
     */
    function getOptions(): ArrayCollection {
        return $this->options;
    }

    /**
     * 
     * @param ArrayCollection $options
     * @return void
     */
    function setOptions(ArrayCollection $options): void {
        $this->options = $options;
    }


}
