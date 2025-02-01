<?php

namespace App\Enums;

/**
 * 言語コードの規格を管理するEnum
 * 
 * ISO 639-1: 2文字のアルファベットコード
 * ISO 639-2/T: 3文字のアルファベットコード（専門用語）
 * ISO 639-2/B: 3文字のアルファベットコード（書誌用）
 * ISO 639-3: 3文字のアルファベットコード（包括的）
 */
enum LanguageCodeStandardEnum: string
{
    case ISO_639_1 = 'iso_639_1';
    case IETF_BCP_47 = 'ietf_bcp_47';
} 