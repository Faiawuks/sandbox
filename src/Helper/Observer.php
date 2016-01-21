<?php

namespace Helper;

class Observer
{
    public function update(ObserverSubject $subject)
    {
        var_dump('*IN PATTERN OBSERVER - NEW PATTERN GOSSIP ALERT*');
        var_dump(' new favorite patterns: '.$subject->getFavorites());
        var_dump('*IN PATTERN OBSERVER - PATTERN GOSSIP ALERT OVER*');
    }
}
