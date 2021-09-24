<?php
function mixedComplex() {
    $a = ${"b{$foo}"}->{"a{$c->{'foo-bar'}()}d"}();
}