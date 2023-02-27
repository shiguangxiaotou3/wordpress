<?php
namespace crud\models;

use yii\base\Model;


/**
 * Class Color
 * @package crud\common\model
 */
class Color extends Model
{

    const NAME_INDIAN_RED = "IndianRed";
    const NAME_LIGHT_CORAL = "LightCoral";
    const NAME_SALMON = "Salmon";
    const NAME_DARK_SALMON = "DarkSalmon";
    const NAME_LIGHT_SALMON = "LightSalmon";
    const NAME_CRIMSON = "Crimson";
    const NAME_RED = "Red";
    const NAME_FIRE_BRICK = "FireBrick";
    const NAME_DARK_RED = "DarkRed";
    const NAME_PINK = "Pink";
    const NAME_LIGHT_PINK = "LightPink";
    const NAME_HOT_PINK = "HotPink";
    const NAME_DEEP_PINK = "DeepPink";
    const NAME_MEDIUM_VIOLET_RED = "MediumVioletRed";
    const NAME_PALE_VIOLET_RED = "PaleVioletRed";

    const NAME_CORAL = "Coral";
    const NAME_TOMATO = "Tomato";
    const NAME_ORANGE_RED = "OrangeRed";
    const NAME_DARK_ORANGE = "DarkOrange";
    const NAME_ORANGE = "Orange";
    const NAME_GOLD = "Gold";
    const NAME_YELLOW = "Yellow";
    const NAME_LIGHT_YELLOW = "LightYellow";
    const NAME_LEMON_CHIFFON = "LemonChiffon";
    const NAME_LIGHT_GOLDENROD_YELLOW = "LightGoldenrodYellow";
    const NAME_PAPAYA_WHIP = "PapayaWhip";
    const NAME_MOCCASIN = "Moccasin";
    const NAME_PEACH_PUFF = "PeachPuff";
    const NAME_PALE_GOLDENROD = "PaleGoldenrod";
    const NAME_KHAKI = "Khaki";
    const NAME_DARK_KHAKI = "DarkKhaki";
    const NAME_LAVENDER = "Lavender";
    const NAME_THISTLE = "Thistle";
    const NAME_PLUM = "Plum";
    const NAME_VIOLET = "Violet";
    const NAME_ORCHID = "Orchid";
    const NAME_FUCHSIA = "Fuchsia";
    const NAME_MAGENTA = "Magenta";
    const NAME_MEDIUM_ORCHID = "MediumOrchid";
    const NAME_MEDIUM_PURPLE = "MediumPurple";
    const NAME_REBECCA_PURPLE = "RebeccaPurple";
    const NAME_BLUE_VIOLET = "BlueViolet";
    const NAME_DARK_VIOLET = "DarkViolet";
    const NAME_DARK_ORCHID = "DarkOrchid";
    const NAME_DARK_MAGENTA = "DarkMagenta";
    const NAME_PURPLE = "Purple";
    const NAME_INDIGO = "Indigo";
    const NAME_SLATE_BLUE = "SlateBlue";
    const NAME_DARK_SLATE_BLUE = "DarkSlateBlue";
    const NAME_MEDIUM_SLATE_BLUE = "MediumSlateBlue";
    const NAME_GREEN_YELLOW = "GreenYellow";
    const NAME_CHARTREUSE = "Chartreuse";
    const NAME_LAWN_GREEN = "LawnGreen";
    const NAME_LIME = "Lime";
    const NAME_LIME_GREEN = "LimeGreen";
    const NAME_PALE_GREEN = "PaleGreen";
    const NAME_LIGHT_GREEN = "LightGreen";
    const NAME_MEDIUM_SPRING_GREEN = "MediumSpringGreen";
    const NAME_SPRING_GREEN = "SpringGreen";
    const NAME_MEDIUM_SEA_GREEN = "MediumSeaGreen";
    const NAME_SEA_GREEN = "SeaGreen";
    const NAME_FOREST_GREEN = "ForestGreen";
    const NAME_GREEN = "Green";
    const NAME_DARK_GREEN = "DarkGreen";
    const NAME_YELLOW_GREEN = "YellowGreen";
    const NAME_OLIVE_DRAB = "OliveDrab";
    const NAME_OLIVE = "Olive";
    const NAME_DARK_OLIVE_GREEN = "DarkOliveGreen";
    const NAME_MEDIUM_AQUAMARINE = "MediumAquamarine";
    const NAME_DARK_SEA_GREEN = "DarkSeaGreen";
    const NAME_LIGHT_SEA_GREEN = "LightSeaGreen";
    const NAME_DARK_CYAN = "DarkCyan";
    const NAME_TEAL = "Teal";
    const NAME_AQUA = "Aqua";
    const NAME_CYAN = "Cyan";
    const NAME_LIGHT_CYAN = "LightCyan";
    const NAME_PALE_TURQUOISE = "PaleTurquoise";
    const NAME_AQUAMARINE = "Aquamarine";
    const NAME_TURQUOISE = "Turquoise";
    const NAME_MEDIUM_TURQUOISE = "MediumTurquoise";
    const NAME_DARK_TURQUOISE = "DarkTurquoise";
    const NAME_CADET_BLUE = "CadetBlue";
    const NAME_STEEL_BLUE = "SteelBlue";
    const NAME_LIGHT_STEEL_BLUE = "LightSteelBlue";
    const NAME_POWDER_BLUE = "PowderBlue";
    const NAME_LIGHT_BLUE = "LightBlue";
    const NAME_SKY_BLUE = "SkyBlue";
    const NAME_LIGHT_SKY_BLUE = "LightSkyBlue";
    const NAME_DEEP_SKY_BLUE = "DeepSkyBlue";
    const NAME_DODGER_BLUE = "DodgerBlue";
    const NAME_CORNFLOWER_BLUE = "CornflowerBlue";

    const NAME_ROYAL_BLUE = "RoyalBlue";
    const NAME_BLUE = "Blue";
    const NAME_MEDIUM_BLUE = "MediumBlue";
    const NAME_DARK_BLUE = "DarkBlue";
    const NAME_NAVY = "Navy";
    const NAME_MIDNIGHT_BLUE = "MidnightBlue";
    const NAME_CORNSILK = "Cornsilk";
    const NAME_BLANCHED_ALMOND = "BlanchedAlmond";
    const NAME_BISQUE = "Bisque";
    const NAME_NAVAJO_WHITE = "NavajoWhite";
    const NAME_WHEAT = "Wheat";
    const NAME_BURLY_WOOD = "BurlyWood";
    const NAME_TAN = "Tan";
    const NAME_ROSY_BROWN = "RosyBrown";
    const NAME_SANDY_BROWN = "SandyBrown";
    const NAME_GOLDENROD = "Goldenrod";
    const NAME_DARK_GOLDENROD = "DarkGoldenrod";
    const NAME_PERU = "Peru";
    const NAME_CHOCOLATE = "Chocolate";
    const NAME_SADDLE_BROWN = "SaddleBrown";
    const NAME_SIENNA = "Sienna";
    const NAME_BROWN = "Brown";
    const NAME_MAROON = "Maroon";
    const NAME_WHITE = "White";
    const NAME_SNOW = "Snow";
    const NAME_HONEY_DEW = "HoneyDew";
    const NAME_MINT_CREAM = "MintCream";
    const NAME_AZURE = "Azure";
    const NAME_ALICE_BLUE = "AliceBlue";
    const NAME_GHOST_WHITE = "GhostWhite";
    const NAME_WHITE_SMOKE = "WhiteSmoke";
    const NAME_SEA_SHELL = "SeaShell";
    const NAME_BEIGE = "Beige";
    const NAME_OLD_LACE = "OldLace";
    const NAME_FLORAL_WHITE = "FloralWhite";
    const NAME_IVORY = "Ivory";
    const NAME_ANTIQUE_WHITE = "AntiqueWhite";
    const NAME_LINEN = "Linen";
    const NAME_LAVENDER_BLUSH = "LavenderBlush";
    const NAME_MISTY_ROSE = "MistyRose";
    const NAME_GAINSBORO = "Gainsboro";
    const NAME_LIGHT_GRAY = "LightGray";
    const NAME_SILVER = "Silver";
    const NAME_DARK_GRAY = "DarkGray";
    const NAME_GRAY = "Gray";
    const NAME_DIM_GRAY = "DimGray";
    const NAME_LIGHT_SLATE_GRAY = "LightSlateGray";
    const NAME_SLATE_GRAY = "SlateGray";
    const NAME_DARK_SLATE_GRAY = "DarkSlateGray";
    const NAME_BLACK = "Black";
    const RBG_INDIAN_RED = "rgb(205,92,92)";
    const RBG_LIGHT_CORAL = "rgb(240,128,128)";
    const RBG_SALMON = "rgb(250,128,114)";
    const RBG_DARK_SALMON = "rgb(233,150,122)";
    const RBG_LIGHT_SALMON = "rgb(255,160,122)";
    const RBG_CRIMSON = "rgb(220,20,60)";
    const RBG_RED = "rgb(255,0,0)";
    const RBG_FIRE_BRICK = "rgb(178,34,34)";
    const RBG_DARK_RED = "rgb(139,0,0)";
    const RBG_PINK = "rgb(255,192,203)";
    const RBG_LIGHT_PINK = "rgb(255,182,193)";
    const RBG_HOT_PINK = "rgb(255,105,180)";
    const RBG_DEEP_PINK = "rgb(255,20,147)";
    const RBG_MEDIUM_VIOLET_RED = "rgb(199,21,133)";
    const RBG_PALE_VIOLET_RED = "rgb(219,112,147)";

    const RBG_CORAL = "rgb(255,127,80)";
    const RBG_TOMATO = "rgb(255,99,71)";
    const RBG_ORANGE_RED = "rgb(255,69,0)";
    const RBG_DARK_ORANGE = "rgb(255,140,0)";
    const RBG_ORANGE = "rgb(255,165,0)";
    const RBG_GOLD = "rgb(255,215,0)";
    const RBG_YELLOW = "rgb(255,255,0)";
    const RBG_LIGHT_YELLOW = "rgb(255,255,224)";
    const RBG_LEMON_CHIFFON = "rgb(255,250,205)";
    const RBG_LIGHT_GOLDENROD_YELLOW = "rgb(250,250,210)";
    const RBG_PAPAYA_WHIP = "rgb(255,239,213)";
    const RBG_MOCCASIN = "rgb(255,228,181)";
    const RBG_PEACH_PUFF = "rgb(255,218,185)";
    const RBG_PALE_GOLDENROD = "rgb(238,232,170)";
    const RBG_KHAKI = "rgb(240,230,140)";
    const RBG_DARK_KHAKI = "rgb(189,183,107)";
    const RBG_LAVENDER = "rgb(230,230,250)";
    const RBG_THISTLE = "rgb(216,191,216)";
    const RBG_PLUM = "rgb(221,160,221)";
    const RBG_VIOLET = "rgb(238,130,238)";
    const RBG_ORCHID = "rgb(218,112,214)";
    const RBG_FUCHSIA = "rgb(255,0,255)";
    const RBG_MAGENTA = "rgb(255,0,255)";
    const RBG_MEDIUM_ORCHID = "rgb(186,85,211)";
    const RBG_MEDIUM_PURPLE = "rgb(147,112,219)";
    const RBG_REBECCA_PURPLE = "rgb(102,51,153)";
    const RBG_BLUE_VIOLET = "rgb(138,43,226)";
    const RBG_DARK_VIOLET = "rgb(148,0,211)";
    const RBG_DARK_ORCHID = "rgb(153,50,204)";
    const RBG_DARK_MAGENTA = "rgb(139,0,139)";
    const RBG_PURPLE = "rgb(128,0,128)";
    const RBG_INDIGO = "rgb(75,0,130)";
    const RBG_SLATE_BLUE = "rgb(106,90,205)";
    const RBG_DARK_SLATE_BLUE = "rgb(72,61,139)";
    const RBG_MEDIUM_SLATE_BLUE = "rgb(123,104,238)";
    const RBG_GREEN_YELLOW = "rgb(173,255,47)";
    const RBG_CHARTREUSE = "rgb(127,255,0)";
    const RBG_LAWN_GREEN = "rgb(124,252,0)";
    const RBG_LIME = "rgb(0,255,0)";
    const RBG_LIME_GREEN = "rgb(50,205,50)";
    const RBG_PALE_GREEN = "rgb(152,251,152)";
    const RBG_LIGHT_GREEN = "rgb(144,238,144)";
    const RBG_MEDIUM_SPRING_GREEN = "rgb(0,250,154)";
    const RBG_SPRING_GREEN = "rgb(0,255,127)";
    const RBG_MEDIUM_SEA_GREEN = "rgb(60,179,113)";
    const RBG_SEA_GREEN = "rgb(46,139,87)";
    const RBG_FOREST_GREEN = "rgb(34,139,34)";
    const RBG_GREEN = "rgb(0,128,0)";
    const RBG_DARK_GREEN = "rgb(0,100,0)";
    const RBG_YELLOW_GREEN = "rgb(154,205,50)";
    const RBG_OLIVE_DRAB = "rgb(107,142,35)";
    const RBG_OLIVE = "rgb(128,128,0)";
    const RBG_DARK_OLIVE_GREEN = "rgb(85,107,47)";
    const RBG_MEDIUM_AQUAMARINE = "rgb(102,205,170)";
    const RBG_DARK_SEA_GREEN = "rgb(143,188,139)";
    const RBG_LIGHT_SEA_GREEN = "rgb(32,178,170)";
    const RBG_DARK_CYAN = "rgb(0,139,139)";
    const RBG_TEAL = "rgb(0,128,128)";
    const RBG_AQUA = "rgb(0,255,255)";
    const RBG_CYAN = "rgb(0,255,255)";
    const RBG_LIGHT_CYAN = "rgb(224,255,255)";
    const RBG_PALE_TURQUOISE = "rgb(175,238,238)";
    const RBG_AQUAMARINE = "rgb(127,255,212)";
    const RBG_TURQUOISE = "rgb(64,224,208)";
    const RBG_MEDIUM_TURQUOISE = "rgb(72,209,204)";
    const RBG_DARK_TURQUOISE = "rgb(0,206,209)";
    const RBG_CADET_BLUE = "rgb(95,158,160)";
    const RBG_STEEL_BLUE = "rgb(70,130,180)";
    const RBG_LIGHT_STEEL_BLUE = "rgb(176,196,222)";
    const RBG_POWDER_BLUE = "rgb(176,224,230)";
    const RBG_LIGHT_BLUE = "rgb(173,216,230)";
    const RBG_SKY_BLUE = "rgb(135,206,235)";
    const RBG_LIGHT_SKY_BLUE = "rgb(135,206,250)";
    const RBG_DEEP_SKY_BLUE = "rgb(0,191,255)";
    const RBG_DODGER_BLUE = "rgb(30,144,255)";
    const RBG_CORNFLOWER_BLUE = "rgb(100,149,237)";

    const RBG_ROYAL_BLUE = "rgb(65,105,225)";
    const RBG_BLUE = "rgb(0,0,255)";
    const RBG_MEDIUM_BLUE = "rgb(0,0,205)";
    const RBG_DARK_BLUE = "rgb(0,0,139)";
    const RBG_NAVY = "rgb(0,0,128)";
    const RBG_MIDNIGHT_BLUE = "rgb(25,25,112)";
    const RBG_CORNSILK = "rgb(255,248,220)";
    const RBG_BLANCHED_ALMOND = "rgb(255,235,205)";
    const RBG_BISQUE = "rgb(255,228,196)";
    const RBG_NAVAJO_WHITE = "rgb(255,222,173)";
    const RBG_WHEAT = "rgb(245,222,179)";
    const RBG_BURLY_WOOD = "rgb(222,184,135)";
    const RBG_TAN = "rgb(210,180,140)";
    const RBG_ROSY_BROWN = "rgb(188,143,143)";
    const RBG_SANDY_BROWN = "rgb(244,164,96)";
    const RBG_GOLDENROD = "rgb(218,165,32)";
    const RBG_DARK_GOLDENROD = "rgb(184,134,11)";
    const RBG_PERU = "rgb(205,133,63)";
    const RBG_CHOCOLATE = "rgb(210,105,30)";
    const RBG_SADDLE_BROWN = "rgb(139,69,19)";
    const RBG_SIENNA = "rgb(160,82,45)";
    const RBG_BROWN = "rgb(165,42,42)";
    const RBG_MAROON = "rgb(128,0,0)";
    const RBG_WHITE = "rgb(255,255,255)";
    const RBG_SNOW = "rgb(255,250,250)";
    const RBG_HONEY_DEW = "rgb(240,255,240)";
    const RBG_MINT_CREAM = "rgb(245,255,250)";
    const RBG_AZURE = "rgb(240,255,255)";
    const RBG_ALICE_BLUE = "rgb(240,248,255)";
    const RBG_GHOST_WHITE = "rgb(248,248,255)";
    const RBG_WHITE_SMOKE = "rgb(245,245,245)";
    const RBG_SEA_SHELL = "rgb(255,245,238)";
    const RBG_BEIGE = "rgb(245,245,220)";
    const RBG_OLD_LACE = "rgb(253,245,230)";
    const RBG_FLORAL_WHITE = "rgb(255,250,240)";
    const RBG_IVORY = "rgb(255,255,240)";
    const RBG_ANTIQUE_WHITE = "rgb(250,235,215)";
    const RBG_LINEN = "rgb(250,240,230)";
    const RBG_LAVENDER_BLUSH = "rgb(255,240,245)";
    const RBG_MISTY_ROSE = "rgb(255,228,225)";
    const RBG_GAINSBORO = "rgb(220,220,220)";
    const RBG_LIGHT_GRAY = "rgb(211,211,211)";
    const RBG_SILVER = "rgb(192,192,192)";
    const RBG_DARK_GRAY = "rgb(169,169,169)";
    const RBG_GRAY = "rgb(128,128,128)";
    const RBG_DIM_GRAY = "rgb(105,105,105)";
    const RBG_LIGHT_SLATE_GRAY = "rgb(119,136,153)";
    const RBG_SLATE_GRAY = "rgb(112,128,144)";
    const RBG_DARK_SLATE_GRAY = "rgb(47,79,79)";
    const RBG_BLACK = "rgb(0,0,0)";
    const HEX_INDIAN_RED = "#CD5C5C";
    const HEX_LIGHT_CORAL = "#F08080";
    const HEX_SALMON = "#FA8072";
    const HEX_DARK_SALMON = "#E9967A";
    const HEX_LIGHT_SALMON = "#FFA07A";
    const HEX_CRIMSON = "#DC143C";
    const HEX_RED = "#FF0000";
    const HEX_FIRE_BRICK = "#B22222";
    const HEX_DARK_RED = "#8B0000";
    const HEX_PINK = "#FFC0CB";
    const HEX_LIGHT_PINK = "#FFB6C1";
    const HEX_HOT_PINK = "#FF69B4";
    const HEX_DEEP_PINK = "#FF1493";
    const HEX_MEDIUM_VIOLET_RED = "#C71585";
    const HEX_PALE_VIOLET_RED = "#DB7093";

    const HEX_CORAL = "#FF7F50";
    const HEX_TOMATO = "#FF6347";
    const HEX_ORANGE_RED = "#FF4500";
    const HEX_DARK_ORANGE = "#FF8C00";
    const HEX_ORANGE = "#FFA500";
    const HEX_GOLD = "#FFD700";
    const HEX_YELLOW = "#FFFF00";
    const HEX_LIGHT_YELLOW = "#FFFFE0";
    const HEX_LEMON_CHIFFON = "#FFFACD";
    const HEX_LIGHT_GOLDENROD_YELLOW = "#FAFAD2";
    const HEX_PAPAYA_WHIP = "#FFEFD5";
    const HEX_MOCCASIN = "#FFE4B5";
    const HEX_PEACH_PUFF = "#FFDAB9";
    const HEX_PALE_GOLDENROD = "#EEE8AA";
    const HEX_KHAKI = "#F0E68C";
    const HEX_DARK_KHAKI = "#BDB76B";
    const HEX_LAVENDER = "#E6E6FA";
    const HEX_THISTLE = "#D8BFD8";
    const HEX_PLUM = "#DDA0DD";
    const HEX_VIOLET = "#EE82EE";
    const HEX_ORCHID = "#DA70D6";
    const HEX_FUCHSIA = "#FF00FF";
    const HEX_MAGENTA = "#FF00FF";
    const HEX_MEDIUM_ORCHID = "#BA55D3";
    const HEX_MEDIUM_PURPLE = "#9370DB";
    const HEX_REBECCA_PURPLE = "#663399";
    const HEX_BLUE_VIOLET = "#8A2BE2";
    const HEX_DARK_VIOLET = "#9400D3";
    const HEX_DARK_ORCHID = "#9932CC";
    const HEX_DARK_MAGENTA = "#8B008B";
    const HEX_PURPLE = "#800080";
    const HEX_INDIGO = "#4B0082";
    const HEX_SLATE_BLUE = "#6A5ACD";
    const HEX_DARK_SLATE_BLUE = "#483D8B";
    const HEX_MEDIUM_SLATE_BLUE = "#7B68EE";
    const HEX_GREEN_YELLOW = "#ADFF2F";
    const HEX_CHARTREUSE = "#7FFF00";
    const HEX_LAWN_GREEN = "#7CFC00";
    const HEX_LIME = "#00FF00";
    const HEX_LIME_GREEN = "#32CD32";
    const HEX_PALE_GREEN = "#98FB98";
    const HEX_LIGHT_GREEN = "#90EE90";
    const HEX_MEDIUM_SPRING_GREEN = "#00FA9A";
    const HEX_SPRING_GREEN = "#00FF7F";
    const HEX_MEDIUM_SEA_GREEN = "#3CB371";
    const HEX_SEA_GREEN = "#2E8B57";
    const HEX_FOREST_GREEN = "#228B22";
    const HEX_GREEN = "#008000";
    const HEX_DARK_GREEN = "#006400";
    const HEX_YELLOW_GREEN = "#9ACD32";
    const HEX_OLIVE_DRAB = "#6B8E23";
    const HEX_OLIVE = "#808000";
    const HEX_DARK_OLIVE_GREEN = "#556B2F";
    const HEX_MEDIUM_AQUAMARINE = "#66CDAA";
    const HEX_DARK_SEA_GREEN = "#8FBC8B";
    const HEX_LIGHT_SEA_GREEN = "#20B2AA";
    const HEX_DARK_CYAN = "#008B8B";
    const HEX_TEAL = "#008080";
    const HEX_AQUA = "#00FFFF";
    const HEX_CYAN = "#00FFFF";
    const HEX_LIGHT_CYAN = "#E0FFFF";
    const HEX_PALE_TURQUOISE = "#AFEEEE";
    const HEX_AQUAMARINE = "#7FFFD4";
    const HEX_TURQUOISE = "#40E0D0";
    const HEX_MEDIUM_TURQUOISE = "#48D1CC";
    const HEX_DARK_TURQUOISE = "#00CED1";
    const HEX_CADET_BLUE = "#5F9EA0";
    const HEX_STEEL_BLUE = "#4682B4";
    const HEX_LIGHT_STEEL_BLUE = "#B0C4DE";
    const HEX_POWDER_BLUE = "#B0E0E6";
    const HEX_LIGHT_BLUE = "#ADD8E6";
    const HEX_SKY_BLUE = "#87CEEB";
    const HEX_LIGHT_SKY_BLUE = "#87CEFA";
    const HEX_DEEP_SKY_BLUE = "#00BFFF";
    const HEX_DODGER_BLUE = "#1E90FF";
    const HEX_CORNFLOWER_BLUE = "#6495ED";

    const HEX_ROYAL_BLUE = "#4169E1";
    const HEX_BLUE = "#0000FF";
    const HEX_MEDIUM_BLUE = "#0000CD";
    const HEX_DARK_BLUE = "#00008B";
    const HEX_NAVY = "#000080";
    const HEX_MIDNIGHT_BLUE = "#191970";
    const HEX_CORNSILK = "#FFF8DC";
    const HEX_BLANCHED_ALMOND = "#FFEBCD";
    const HEX_BISQUE = "#FFE4C4";
    const HEX_NAVAJO_WHITE = "#FFDEAD";
    const HEX_WHEAT = "#F5DEB3";
    const HEX_BURLY_WOOD = "#DEB887";
    const HEX_TAN = "#D2B48C";
    const HEX_ROSY_BROWN = "#BC8F8F";
    const HEX_SANDY_BROWN = "#F4A460";
    const HEX_GOLDENROD = "#DAA520";
    const HEX_DARK_GOLDENROD = "#B8860B";
    const HEX_PERU = "#CD853F";
    const HEX_CHOCOLATE = "#D2691E";
    const HEX_SADDLE_BROWN = "#8B4513";
    const HEX_SIENNA = "#A0522D";
    const HEX_BROWN = "#A52A2A";
    const HEX_MAROON = "#800000";
    const HEX_WHITE = "#FFFFFF";
    const HEX_SNOW = "#FFFAFA";
    const HEX_HONEY_DEW = "#F0FFF0";
    const HEX_MINT_CREAM = "#F5FFFA";
    const HEX_AZURE = "#F0FFFF";
    const HEX_ALICE_BLUE = "#F0F8FF";
    const HEX_GHOST_WHITE = "#F8F8FF";
    const HEX_WHITE_SMOKE = "#F5F5F5";
    const HEX_SEA_SHELL = "#FFF5EE";
    const HEX_BEIGE = "#F5F5DC";
    const HEX_OLD_LACE = "#FDF5E6";
    const HEX_FLORAL_WHITE = "#FFFAF0";
    const HEX_IVORY = "#FFFFF0";
    const HEX_ANTIQUE_WHITE = "#FAEBD7";
    const HEX_LINEN = "#FAF0E6";
    const HEX_LAVENDER_BLUSH = "#FFF0F5";
    const HEX_MISTY_ROSE = "#FFE4E1";
    const HEX_GAINSBORO = "#DCDCDC";
    const HEX_LIGHT_GRAY = "#D3D3D3";
    const HEX_SILVER = "#C0C0C0";
    const HEX_DARK_GRAY = "#A9A9A9";
    const HEX_GRAY = "#808080";
    const HEX_DIM_GRAY = "#696969";
    const HEX_LIGHT_SLATE_GRAY = "#778899";
    const HEX_SLATE_GRAY = "#708090";
    const HEX_DARK_SLATE_GRAY = "#2F4F4F";
    const HEX_BLACK = "#000000";

    public static function color(){
        return [
            ["name" => "IndianRed", "color" => "#CD5C5C", "rgb" => "rgb(205,92,92)"],
            ["name" => "LightCoral", "color" => "#F08080", "rgb" => "rgb(240,128,128)"],
            ["name" => "Salmon", "color" => "#FA8072", "rgb" => "rgb(250,128,114)"],
            ["name" => "DarkSalmon", "color" => "#E9967A", "rgb" => "rgb(233,150,122)"],
            ["name" => "LightSalmon", "color" => "#FFA07A", "rgb" => "rgb(255,160,122)"],
            ["name" => "Crimson", "color" => "#DC143C", "rgb" => "rgb(220,20,60)"],
            ["name" => "Red", "color" => "#FF0000", "rgb" => "rgb(255,0,0)"],
            ["name" => "FireBrick", "color" => "#B22222", "rgb" => "rgb(178,34,34)"],
            ["name" => "DarkRed", "color" => "#8B0000", "rgb" => "rgb(139,0,0)"],
            ["name" => "Pink", "color" => "#FFC0CB", "rgb" => "rgb(255,192,203)"],
            ["name" => "LightPink", "color" => "#FFB6C1", "rgb" => "rgb(255,182,193)"],
            ["name" => "HotPink", "color" => "#FF69B4", "rgb" => "rgb(255,105,180)"],
            ["name" => "DeepPink", "color" => "#FF1493", "rgb" => "rgb(255,20,147)"],
            ["name" => "MediumVioletRed", "color" => "#C71585", "rgb" => "rgb(199,21,133)"],
            ["name" => "PaleVioletRed", "color" => "#DB7093", "rgb" => "rgb(219,112,147)"],
            ["name" => "LightSalmon", "color" => "#FFA07A", "rgb" => "rgb(255,160,122)"],
            ["name" => "Coral", "color" => "#FF7F50", "rgb" => "rgb(255,127,80)"],
            ["name" => "Tomato", "color" => "#FF6347", "rgb" => "rgb(255,99,71)"],
            ["name" => "OrangeRed", "color" => "#FF4500", "rgb" => "rgb(255,69,0)"],
            ["name" => "DarkOrange", "color" => "#FF8C00", "rgb" => "rgb(255,140,0)"],
            ["name" => "Orange", "color" => "#FFA500", "rgb" => "rgb(255,165,0)"],
            ["name" => "Gold", "color" => "#FFD700", "rgb" => "rgb(255,215,0)"],
            ["name" => "Yellow", "color" => "#FFFF00", "rgb" => "rgb(255,255,0)"],
            ["name" => "LightYellow", "color" => "#FFFFE0", "rgb" => "rgb(255,255,224)"],
            ["name" => "LemonChiffon", "color" => "#FFFACD", "rgb" => "rgb(255,250,205)"],
            ["name" => "LightGoldenrodYellow", "color" => "#FAFAD2", "rgb" => "rgb(250,250,210)"],
            ["name" => "PapayaWhip", "color" => "#FFEFD5", "rgb" => "rgb(255,239,213)"],
            ["name" => "Moccasin", "color" => "#FFE4B5", "rgb" => "rgb(255,228,181)"],
            ["name" => "PeachPuff", "color" => "#FFDAB9", "rgb" => "rgb(255,218,185)"],
            ["name" => "PaleGoldenrod", "color" => "#EEE8AA", "rgb" => "rgb(238,232,170)"],
            ["name" => "Khaki", "color" => "#F0E68C", "rgb" => "rgb(240,230,140)"],
            ["name" => "DarkKhaki", "color" => "#BDB76B", "rgb" => "rgb(189,183,107)"],
            ["name" => "Lavender", "color" => "#E6E6FA", "rgb" => "rgb(230,230,250)"],
            ["name" => "Thistle", "color" => "#D8BFD8", "rgb" => "rgb(216,191,216)"],
            ["name" => "Plum", "color" => "#DDA0DD", "rgb" => "rgb(221,160,221)"],
            ["name" => "Violet", "color" => "#EE82EE", "rgb" => "rgb(238,130,238)"],
            ["name" => "Orchid", "color" => "#DA70D6", "rgb" => "rgb(218,112,214)"],
            ["name" => "Fuchsia", "color" => "#FF00FF", "rgb" => "rgb(255,0,255)"],
            ["name" => "Magenta", "color" => "#FF00FF", "rgb" => "rgb(255,0,255)"],
            ["name" => "MediumOrchid", "color" => "#BA55D3", "rgb" => "rgb(186,85,211)"],
            ["name" => "MediumPurple", "color" => "#9370DB", "rgb" => "rgb(147,112,219)"],
            ["name" => "RebeccaPurple", "color" => "#663399", "rgb" => "rgb(102,51,153)"],
            ["name" => "BlueViolet", "color" => "#8A2BE2", "rgb" => "rgb(138,43,226)"],
            ["name" => "DarkViolet", "color" => "#9400D3", "rgb" => "rgb(148,0,211)"],
            ["name" => "DarkOrchid", "color" => "#9932CC", "rgb" => "rgb(153,50,204)"],
            ["name" => "DarkMagenta", "color" => "#8B008B", "rgb" => "rgb(139,0,139)"],
            ["name" => "Purple", "color" => "#800080", "rgb" => "rgb(128,0,128)"],
            ["name" => "Indigo", "color" => "#4B0082", "rgb" => "rgb(75,0,130)"],
            ["name" => "SlateBlue", "color" => "#6A5ACD", "rgb" => "rgb(106,90,205)"],
            ["name" => "DarkSlateBlue", "color" => "#483D8B", "rgb" => "rgb(72,61,139)"],
            ["name" => "MediumSlateBlue", "color" => "#7B68EE", "rgb" => "rgb(123,104,238)"],
            ["name" => "GreenYellow", "color" => "#ADFF2F", "rgb" => "rgb(173,255,47)"],
            ["name" => "Chartreuse", "color" => "#7FFF00", "rgb" => "rgb(127,255,0)"],
            ["name" => "LawnGreen", "color" => "#7CFC00", "rgb" => "rgb(124,252,0)"],
            ["name" => "Lime", "color" => "#00FF00", "rgb" => "rgb(0,255,0)"],
            ["name" => "LimeGreen", "color" => "#32CD32", "rgb" => "rgb(50,205,50)"],
            ["name" => "PaleGreen", "color" => "#98FB98", "rgb" => "rgb(152,251,152)"],
            ["name" => "LightGreen", "color" => "#90EE90", "rgb" => "rgb(144,238,144)"],
            ["name" => "MediumSpringGreen", "color" => "#00FA9A", "rgb" => "rgb(0,250,154)"],
            ["name" => "SpringGreen", "color" => "#00FF7F", "rgb" => "rgb(0,255,127)"],
            ["name" => "MediumSeaGreen", "color" => "#3CB371", "rgb" => "rgb(60,179,113)"],
            ["name" => "SeaGreen", "color" => "#2E8B57", "rgb" => "rgb(46,139,87)"],
            ["name" => "ForestGreen", "color" => "#228B22", "rgb" => "rgb(34,139,34)"],
            ["name" => "Green", "color" => "#008000", "rgb" => "rgb(0,128,0)"],
            ["name" => "DarkGreen", "color" => "#006400", "rgb" => "rgb(0,100,0)"],
            ["name" => "YellowGreen", "color" => "#9ACD32", "rgb" => "rgb(154,205,50)"],
            ["name" => "OliveDrab", "color" => "#6B8E23", "rgb" => "rgb(107,142,35)"],
            ["name" => "Olive", "color" => "#808000", "rgb" => "rgb(128,128,0)"],
            ["name" => "DarkOliveGreen", "color" => "#556B2F", "rgb" => "rgb(85,107,47)"],
            ["name" => "MediumAquamarine", "color" => "#66CDAA", "rgb" => "rgb(102,205,170)"],
            ["name" => "DarkSeaGreen", "color" => "#8FBC8B", "rgb" => "rgb(143,188,139)"],
            ["name" => "LightSeaGreen", "color" => "#20B2AA", "rgb" => "rgb(32,178,170)"],
            ["name" => "DarkCyan", "color" => "#008B8B", "rgb" => "rgb(0,139,139)"],
            ["name" => "Teal", "color" => "#008080", "rgb" => "rgb(0,128,128)"],
            ["name" => "Aqua", "color" => "#00FFFF", "rgb" => "rgb(0,255,255)"],
            ["name" => "Cyan", "color" => "#00FFFF", "rgb" => "rgb(0,255,255)"],
            ["name" => "LightCyan", "color" => "#E0FFFF", "rgb" => "rgb(224,255,255)"],
            ["name" => "PaleTurquoise", "color" => "#AFEEEE", "rgb" => "rgb(175,238,238)"],
            ["name" => "Aquamarine", "color" => "#7FFFD4", "rgb" => "rgb(127,255,212)"],
            ["name" => "Turquoise", "color" => "#40E0D0", "rgb" => "rgb(64,224,208)"],
            ["name" => "MediumTurquoise", "color" => "#48D1CC", "rgb" => "rgb(72,209,204)"],
            ["name" => "DarkTurquoise", "color" => "#00CED1", "rgb" => "rgb(0,206,209)"],
            ["name" => "CadetBlue", "color" => "#5F9EA0", "rgb" => "rgb(95,158,160)"],
            ["name" => "SteelBlue", "color" => "#4682B4", "rgb" => "rgb(70,130,180)"],
            ["name" => "LightSteelBlue", "color" => "#B0C4DE", "rgb" => "rgb(176,196,222)"],
            ["name" => "PowderBlue", "color" => "#B0E0E6", "rgb" => "rgb(176,224,230)"],
            ["name" => "LightBlue", "color" => "#ADD8E6", "rgb" => "rgb(173,216,230)"],
            ["name" => "SkyBlue", "color" => "#87CEEB", "rgb" => "rgb(135,206,235)"],
            ["name" => "LightSkyBlue", "color" => "#87CEFA", "rgb" => "rgb(135,206,250)"],
            ["name" => "DeepSkyBlue", "color" => "#00BFFF", "rgb" => "rgb(0,191,255)"],
            ["name" => "DodgerBlue", "color" => "#1E90FF", "rgb" => "rgb(30,144,255)"],
            ["name" => "CornflowerBlue", "color" => "#6495ED", "rgb" => "rgb(100,149,237)"],
            ["name" => "MediumSlateBlue", "color" => "#7B68EE", "rgb" => "rgb(123,104,238)"],
            ["name" => "RoyalBlue", "color" => "#4169E1", "rgb" => "rgb(65,105,225)"],
            ["name" => "Blue", "color" => "#0000FF", "rgb" => "rgb(0,0,255)"],
            ["name" => "MediumBlue", "color" => "#0000CD", "rgb" => "rgb(0,0,205)"],
            ["name" => "DarkBlue", "color" => "#00008B", "rgb" => "rgb(0,0,139)"],
            ["name" => "Navy", "color" => "#000080", "rgb" => "rgb(0,0,128)"],
            ["name" => "MidnightBlue", "color" => "#191970", "rgb" => "rgb(25,25,112)"],
            ["name" => "Cornsilk", "color" => "#FFF8DC", "rgb" => "rgb(255,248,220)"],
            ["name" => "BlanchedAlmond", "color" => "#FFEBCD", "rgb" => "rgb(255,235,205)"],
            ["name" => "Bisque", "color" => "#FFE4C4", "rgb" => "rgb(255,228,196)"],
            ["name" => "NavajoWhite", "color" => "#FFDEAD", "rgb" => "rgb(255,222,173)"],
            ["name" => "Wheat", "color" => "#F5DEB3", "rgb" => "rgb(245,222,179)"],
            ["name" => "BurlyWood", "color" => "#DEB887", "rgb" => "rgb(222,184,135)"],
            ["name" => "Tan", "color" => "#D2B48C", "rgb" => "rgb(210,180,140)"],
            ["name" => "RosyBrown", "color" => "#BC8F8F", "rgb" => "rgb(188,143,143)"],
            ["name" => "SandyBrown", "color" => "#F4A460", "rgb" => "rgb(244,164,96)"],
            ["name" => "Goldenrod", "color" => "#DAA520", "rgb" => "rgb(218,165,32)"],
            ["name" => "DarkGoldenrod", "color" => "#B8860B", "rgb" => "rgb(184,134,11)"],
            ["name" => "Peru", "color" => "#CD853F", "rgb" => "rgb(205,133,63)"],
            ["name" => "Chocolate", "color" => "#D2691E", "rgb" => "rgb(210,105,30)"],
            ["name" => "SaddleBrown", "color" => "#8B4513", "rgb" => "rgb(139,69,19)"],
            ["name" => "Sienna", "color" => "#A0522D", "rgb" => "rgb(160,82,45)"],
            ["name" => "Brown", "color" => "#A52A2A", "rgb" => "rgb(165,42,42)"],
            ["name" => "Maroon", "color" => "#800000", "rgb" => "rgb(128,0,0)"],
            ["name" => "White", "color" => "#FFFFFF", "rgb" => "rgb(255,255,255)"],
            ["name" => "Snow", "color" => "#FFFAFA", "rgb" => "rgb(255,250,250)"],
            ["name" => "HoneyDew", "color" => "#F0FFF0", "rgb" => "rgb(240,255,240)"],
            ["name" => "MintCream", "color" => "#F5FFFA", "rgb" => "rgb(245,255,250)"],
            ["name" => "Azure", "color" => "#F0FFFF", "rgb" => "rgb(240,255,255)"],
            ["name" => "AliceBlue", "color" => "#F0F8FF", "rgb" => "rgb(240,248,255)"],
            ["name" => "GhostWhite", "color" => "#F8F8FF", "rgb" => "rgb(248,248,255)"],
            ["name" => "WhiteSmoke", "color" => "#F5F5F5", "rgb" => "rgb(245,245,245)"],
            ["name" => "SeaShell", "color" => "#FFF5EE", "rgb" => "rgb(255,245,238)"],
            ["name" => "Beige", "color" => "#F5F5DC", "rgb" => "rgb(245,245,220)"],
            ["name" => "OldLace", "color" => "#FDF5E6", "rgb" => "rgb(253,245,230)"],
            ["name" => "FloralWhite", "color" => "#FFFAF0", "rgb" => "rgb(255,250,240)"],
            ["name" => "Ivory", "color" => "#FFFFF0", "rgb" => "rgb(255,255,240)"],
            ["name" => "AntiqueWhite", "color" => "#FAEBD7", "rgb" => "rgb(250,235,215)"],
            ["name" => "Linen", "color" => "#FAF0E6", "rgb" => "rgb(250,240,230)"],
            ["name" => "LavenderBlush", "color" => "#FFF0F5", "rgb" => "rgb(255,240,245)"],
            ["name" => "MistyRose", "color" => "#FFE4E1", "rgb" => "rgb(255,228,225)"],
            ["name" => "Gainsboro", "color" => "#DCDCDC", "rgb" => "rgb(220,220,220)"],
            ["name" => "LightGray", "color" => "#D3D3D3", "rgb" => "rgb(211,211,211)"],
            ["name" => "Silver", "color" => "#C0C0C0", "rgb" => "rgb(192,192,192)"],
            ["name" => "DarkGray", "color" => "#A9A9A9", "rgb" => "rgb(169,169,169)"],
            ["name" => "Gray", "color" => "#808080", "rgb" => "rgb(128,128,128)"],
            ["name" => "DimGray", "color" => "#696969", "rgb" => "rgb(105,105,105)"],
            ["name" => "LightSlateGray", "color" => "#778899", "rgb" => "rgb(119,136,153)"],
            ["name" => "SlateGray", "color" => "#708090", "rgb" => "rgb(112,128,144)"],
            ["name" => "DarkSlateGray", "color" => "#2F4F4F", "rgb" => "rgb(47,79,79)"],
            ["name" => "Black", "color" => "#000000", "rgb" => "rgb(0,0,0)"],
        ];
    }

    /**
     * @return string
     */
    public static function randName(){
        $data = self::color();
        $n = rand(0 ,count($data)-1);
        return $data[$n]["name"];
    }

    /**
     * @return string
     */
    public static function randHex(){
        $data = self::color();
        $n = rand(0 ,count($data)-1);
        return $data[$n]["color"];
    }

    /**
     * @return string
     */
    public static function randRgb(){
        $data = self::color();
        $n = rand(0 ,count($data)-1);
        return $data[$n]["rgb"];
    }
//
//    const NAME_LIGHT_SALMON = "LightSalmon";
//    const HEX_LIGHT_SALMON = "#FFA07A";
//    const RBG_LIGHT_SALMON = "rgb(255,160,122)";

//    const RBG_MEDIUM_SLATE_BLUE = "rgb(123,104,238)";
//    const HEX_MEDIUM_SLATE_BLUE = "#7B68EE";
//    const NAME_MEDIUM_SLATE_BLUE = "MediumSlateBlue";

}