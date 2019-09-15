<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movies
 *
 * @ORM\Table(name="movies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MoviesRepository")
 */
class Movies
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="film_name", type="string", length=255)
     */
    private $filmName;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="lead_studio", type="string", length=255)
     */
    private $leadStudio;

    /**
     * @var float
     *
     * @ORM\Column(name="audience_score", type="float")
     */
    private $audienceScore;

    /**
     * @var float
     *
     * @ORM\Column(name="profitability", type="float")
     */
    private $profitability;

    /**
     * @var int
     *
     * @ORM\Column(name="rotten_tomatoes", type="integer")
     */
    private $rottenTomatoes;

    /**
     * @var float
     *
     * @ORM\Column(name="worldwide_gross", type="float")
     */
    private $worldwideGross;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filmName
     *
     * @param string $filmName
     *
     * @return Movies
     */
    public function setFilmName($filmName)
    {
        $this->filmName = $filmName;

        return $this;
    }

    /**
     * Get filmName
     *
     * @return string
     */
    public function getFilmName()
    {
        return $this->filmName;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return Movies
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set leadStudio
     *
     * @param string $leadStudio
     *
     * @return Movies
     */
    public function setLeadStudio($leadStudio)
    {
        $this->leadStudio = $leadStudio;

        return $this;
    }

    /**
     * Get leadStudio
     *
     * @return string
     */
    public function getLeadStudio()
    {
        return $this->leadStudio;
    }

    /**
     * Set audienceScore
     *
     * @param string $audienceScore
     *
     * @return Movies
     */
    public function setAudienceScore($audienceScore)
    {
        $this->audienceScore = $audienceScore;

        return $this;
    }

    /**
     * Get audienceScore
     *
     * @return string
     */
    public function getAudienceScore()
    {
        return $this->audienceScore;
    }

    /**
     * Set profitability
     *
     * @param float $profitability
     *
     * @return Movies
     */
    public function setProfitability($profitability)
    {
        $this->profitability = $profitability;

        return $this;
    }

    /**
     * Get profitability
     *
     * @return float
     */
    public function getProfitability()
    {
        return $this->profitability;
    }

    /**
     * Set rottenTomatoes
     *
     * @param integer $rottenTomatoes
     *
     * @return Movies
     */
    public function setRottenTomatoes($rottenTomatoes)
    {
        $this->rottenTomatoes = $rottenTomatoes;

        return $this;
    }

    /**
     * Get rottenTomatoes
     *
     * @return int
     */
    public function getRottenTomatoes()
    {
        return $this->rottenTomatoes;
    }

    /**
     * Set worldwideGross
     *
     * @param float $worldwideGross
     *
     * @return Movies
     */
    public function setWorldwideGross($worldwideGross)
    {
        $this->worldwideGross = $worldwideGross;

        return $this;
    }

    /**
     * Get worldwideGross
     *
     * @return float
     */
    public function getWorldwideGross()
    {
        return $this->worldwideGross;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Movies
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return [
            'id' => $this->getId(),
            'Film' => $this->getFilmName(),
            'Genre' => $this->getGenre(),
            'Lead Studio' => $this->getLeadStudio(),
            'Audience score %' => $this->getAudienceScore(),
            'Profitability' => $this->getProfitability(),
            'Rotten Tomatoes %' => $this->getRottenTomatoes(),
            'Worldwide Gross' => $this->getWorldwideGross(),
            'Year' => $this->getYear()
        ];
    }
}

