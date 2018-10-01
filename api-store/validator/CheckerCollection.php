<?php
namespace asbamboo\api\apiStore\validator;

/**
 *
 * @author 李春寅 <licy2013@aliyun.com>
 * @since 2018年9月30日
 */
class CheckerCollection implements CheckerCollectionInterface
{
    /**
     *
     * @var CheckerInterface[]
     */
    private $checkers;

    /**
     *
     * @param CheckerInterface ...$checkers
     */
    public function __construct(CheckerInterface ...$checkers)
    {
        foreach($checkers AS $Checker){
            $this->add($Checker);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\validator\CheckerCollectionInterface::add()
     */
    public function add(CheckerInterface $Checker) : CheckerCollectionInterface
    {
        $id                     = spl_object_hash($Checker);
        $this->checkers[$id]    = $Checker;
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \asbamboo\api\apiStore\validator\CheckerCollectionInterface::remove()
     */
    public function remove(CheckerInterface $Checker) : CheckerCollectionInterface
    {
        $id                     = spl_object_hash($Checker);
        unset($this->checkers[$id]);
        return $this;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::current()
     */
    public function current()
    {
        return current($this->checkers);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::next()
     */
    public function next()
    {
        return next($this->checkers);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::key()
     */
    public function key()
    {
        return key($this->checkers);
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::valid()
     */
    public function valid()
    {
        return $this->current() !== false;
    }

    /**
     *
     * {@inheritDoc}
     * @see \Iterator::rewind()
     */
    public function rewind()
    {
        reset($this->checkers);
    }
}