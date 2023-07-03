<?php

namespace Core\Domain\Entity\Usuario\ValueObjects;

enum TipoUsuario
{
    case PESSOA_FISICA;
    case ABRIGO;
    case ASSOCIACAO;
}
