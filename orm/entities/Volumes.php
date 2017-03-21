<?php



/**
 * Volumes
 */
class Volumes
{
    /**
     * @var string
     */
    private $volumeTitle;

    /**
     * @var string
     */
    private $volumeLongTitle;

    /**
     * @var string
     */
    private $volumeSubtitle;

    /**
     * @var string
     */
    private $volumeShortTitle;

    /**
     * @var string
     */
    private $volumeLdsUrl;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set volumeTitle
     *
     * @param string $volumeTitle
     *
     * @return Volumes
     */
    public function setVolumeTitle($volumeTitle)
    {
        $this->volumeTitle = $volumeTitle;

        return $this;
    }

    /**
     * Get volumeTitle
     *
     * @return string
     */
    public function getVolumeTitle()
    {
        return $this->volumeTitle;
    }

    /**
     * Set volumeLongTitle
     *
     * @param string $volumeLongTitle
     *
     * @return Volumes
     */
    public function setVolumeLongTitle($volumeLongTitle)
    {
        $this->volumeLongTitle = $volumeLongTitle;

        return $this;
    }

    /**
     * Get volumeLongTitle
     *
     * @return string
     */
    public function getVolumeLongTitle()
    {
        return $this->volumeLongTitle;
    }

    /**
     * Set volumeSubtitle
     *
     * @param string $volumeSubtitle
     *
     * @return Volumes
     */
    public function setVolumeSubtitle($volumeSubtitle)
    {
        $this->volumeSubtitle = $volumeSubtitle;

        return $this;
    }

    /**
     * Get volumeSubtitle
     *
     * @return string
     */
    public function getVolumeSubtitle()
    {
        return $this->volumeSubtitle;
    }

    /**
     * Set volumeShortTitle
     *
     * @param string $volumeShortTitle
     *
     * @return Volumes
     */
    public function setVolumeShortTitle($volumeShortTitle)
    {
        $this->volumeShortTitle = $volumeShortTitle;

        return $this;
    }

    /**
     * Get volumeShortTitle
     *
     * @return string
     */
    public function getVolumeShortTitle()
    {
        return $this->volumeShortTitle;
    }

    /**
     * Set volumeLdsUrl
     *
     * @param string $volumeLdsUrl
     *
     * @return Volumes
     */
    public function setVolumeLdsUrl($volumeLdsUrl)
    {
        $this->volumeLdsUrl = $volumeLdsUrl;

        return $this;
    }

    /**
     * Get volumeLdsUrl
     *
     * @return string
     */
    public function getVolumeLdsUrl()
    {
        return $this->volumeLdsUrl;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

