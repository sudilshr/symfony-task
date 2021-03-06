<?php

namespace TaskManagerBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * Projects
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TaskManagerBundle\Entity\Repository\ProjectsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Projects
{
	
	/**
	 *
	 * @ORM\OneToMany(targetEntity="Tasks", mappedBy="projects")
	 */
	protected $tasks;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=30)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean")
     */
    private $completed;

    /**
     * @var \date
     *
     * @ORM\Column(name="due_date", type="date")
     */
    private $dueDate;

    /**
     * @var \date
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;

    /**
     * @var \date
     *
     * @ORM\Column(name="updated", type="date")
     */
    private $updated;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Projects
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     * @return Projects
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean 
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set dueDate
     *
     * @param \date $dueDate
     * @return Projects
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \date 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set created
     *
     * @param \date $created
     * @return Projects
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \date 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \date $updated
     * @return Projects
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \date 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
    	$this->created = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
    	$this->updated = new \DateTime();
    }
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tasks
     *
     * @param \TaskManagerBundle\Entity\Tasks $tasks
     * @return Projects
     */
    public function addTask(\TaskManagerBundle\Entity\Tasks $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \TaskManagerBundle\Entity\Tasks $tasks
     */
    public function removeTask(\TaskManagerBundle\Entity\Tasks $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
    
	public function getCompleteTasks()
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();

        $criteria->where($expr->eq('completed', true));

        return $this->getTasks()->matching($criteria);
    }

    public function getNumberOfTasks()
    {
        return $this->getTasks()->count();
    }

    public function getPercentComplete()
    {
        $percentage = 0;
        $totalSize = $this->getNumberOfTasks();
        if ($totalSize>0)
        {
            $completedSize = $this->getCompleteTasks()->count();
            $percentage =  $completedSize / $totalSize * 100;
        }

        return $percentage;
        }

}
