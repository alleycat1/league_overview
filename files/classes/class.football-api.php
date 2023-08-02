<?php
class Football extends Config {
    public function countries() {
        return $this->query("countries");
    }
}