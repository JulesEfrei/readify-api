<?php

namespace App\Entity\Book;

enum StateBookEnum: string
{

    case NEW = "new";
    case CLEAN = "clean";
    case LOW_DAMAGED = "slightly damaged";
    case MID_DAMAGED = "moderately damaged";
    case HIGH_DAMAGED = "heavily damaged";

}
