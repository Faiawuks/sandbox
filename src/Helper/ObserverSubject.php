<?php

namespace Helper;

class ObserverSubject
{
    private $favorites = null;

    private $observers = array();

    function attach(Observer $observer_in)
    {
        array_push($this->observers, $observer_in);
    }

    function detach(Observer $observer_in)
    {
        $key = array_search($observer_in, $this->observers);
        if (false !== $key) {
            unset ($this->observers[$key]);
        }
    }

    function notify()
    {
        foreach($this->observers as $obs) {
            $obs->update($this);
        }
    }

    function updateFavorites($newFavorites)
    {
        $this->favorites = $newFavorites;
        $this->notify();
    }

    function getFavorites()
    {
        return $this->favorites;
    }
}
