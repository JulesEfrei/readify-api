<?php

namespace App\Entity\Book;

enum StatusBookEnum: string
{

    case AVAILABLE = "available";
    case NOT_AVAILABLE = "not available";
    case BORROWED = "borrowed";

}
