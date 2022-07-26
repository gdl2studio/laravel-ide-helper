<?php
    // 2.5+ API
    if (isNewApi()) {
        echo "new API";
    // 2.4- API
    } elseif (isOldApi()) {
        echo "old API";
    // 2.4- API
    } else {
        echo "unknown API";
        // sth
    }

    return $this->guess($class, $property, function (Constraint $constraint) use ($guesser) {
        return $guesser->guessRequiredForConstraint($constraint);
    // Fallback to false...
    // ... due to sth...
    }, false);
    