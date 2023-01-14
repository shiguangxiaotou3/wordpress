<?php


namespace crud\modules\wp\models;


use yii\base\Model;

/**
 * 图标助手
 * @package crud\modules\wp\models
 */
class Icons extends Model
{
    const FA_500PX = "fa-500px";
    const FA_ADJUST = "fa-adjust";
    const FA_ADN = "fa-adn";
    const FA_ALIGN_CENTER = "fa-align-center";
    const FA_ALIGN_JUSTIFY = "fa-align-justify";
    const FA_ALIGN_LEFT = "fa-align-left";
    const FA_ALIGN_RIGHT = "fa-align-right";
    const FA_AMAZON = "fa-amazon";
    const FA_AMBULANCE = "fa-ambulance";
    const FA_ANCHOR = "fa-anchor";
    const FA_ANDROID = "fa-android";
    const FA_ANGELLIST = "fa-angellist";
    const FA_ANGLE_DOUBLE_DOWN = "fa-angle-double-down";
    const FA_ANGLE_DOUBLE_LEFT = "fa-angle-double-left";
    const FA_ANGLE_DOUBLE_RIGHT = "fa-angle-double-right";
    const FA_ANGLE_DOUBLE_UP = "fa-angle-double-up";
    const FA_ANGLE_DOWN = "fa-angle-down";
    const FA_ANGLE_LEFT = "fa-angle-left";
    const FA_ANGLE_RIGHT = "fa-angle-right";
    const FA_ANGLE_UP = "fa-angle-up";
    const FA_APPLE = "fa-apple";
    const FA_ARCHIVE = "fa-archive";
    const FA_AREA_CHART = "fa-area-chart";
    const FA_ARROW_CIRCLE_DOWN = "fa-arrow-circle-down";
    const FA_ARROW_CIRCLE_LEFT = "fa-arrow-circle-left";
    const FA_ARROW_CIRCLE_O_DOWN = "fa-arrow-circle-o-down";
    const FA_ARROW_CIRCLE_O_LEFT = "fa-arrow-circle-o-left";
    const FA_ARROW_CIRCLE_O_RIGHT = "fa-arrow-circle-o-right";
    const FA_ARROW_CIRCLE_O_UP = "fa-arrow-circle-o-up";
    const FA_ARROW_CIRCLE_RIGHT = "fa-arrow-circle-right";
    const FA_ARROW_CIRCLE_UP = "fa-arrow-circle-up";
    const FA_ARROW_DOWN = "fa-arrow-down";
    const FA_ARROW_LEFT = "fa-arrow-left";
    const FA_ARROW_RIGHT = "fa-arrow-right";
    const FA_ARROW_UP = "fa-arrow-up";
    const FA_ARROWS = "fa-arrows";
    const FA_ARROWS_ALT = "fa-arrows-alt";
    const FA_ARROWS_H = "fa-arrows-h";
    const FA_ARROWS_V = "fa-arrows-v";
    const FA_ASTERISK = "fa-asterisk";
    const FA_AT = "fa-at";
    const FA_BACKWARD = "fa-backward";
    const FA_BALANCE_SCALE = "fa-balance-scale";
    const FA_BAN = "fa-ban";
    const FA_BAR_CHART = "fa-bar-chart";
    const FA_BARCODE = "fa-barcode";
    const FA_BARS = "fa-bars";
    const FA_BATTERY_EMPTY = "fa-battery-empty";
    const FA_BATTERY_FULL = "fa-battery-full";
    const FA_BATTERY_HALF = "fa-battery-half";
    const FA_BATTERY_QUARTER = "fa-battery-quarter";
    const FA_BATTERY_THREE_QUARTERS = "fa-battery-three-quarters";
    const FA_BED = "fa-bed";
    const FA_BEER = "fa-beer";
    const FA_BEHANCE = "fa-behance";
    const FA_BEHANCE_SQUARE = "fa-behance-square";
    const FA_BELL = "fa-bell";
    const FA_BELL_O = "fa-bell-o";
    const FA_BELL_SLASH = "fa-bell-slash";
    const FA_BELL_SLASH_O = "fa-bell-slash-o";
    const FA_BICYCLE = "fa-bicycle";
    const FA_BINOCULARS = "fa-binoculars";
    const FA_BIRTHDAY_CAKE = "fa-birthday-cake";
    const FA_BITBUCKET = "fa-bitbucket";
    const FA_BITBUCKET_SQUARE = "fa-bitbucket-square";
    const FA_BLACK_TIE = "fa-black-tie";
    const FA_BOLD = "fa-bold";
    const FA_BOLT = "fa-bolt";
    const FA_BOMB = "fa-bomb";
    const FA_BOOK = "fa-book";
    const FA_BOOKMARK = "fa-bookmark";
    const FA_BOOKMARK_O = "fa-bookmark-o";
    const FA_BRIEFCASE = "fa-briefcase";
    const FA_BTC = "fa-btc";
    const FA_BUG = "fa-bug";
    const FA_BUILDING = "fa-building";
    const FA_BUILDING_O = "fa-building-o";
    const FA_BULLHORN = "fa-bullhorn";
    const FA_BULLSEYE = "fa-bullseye";
    const FA_BUS = "fa-bus";
    const FA_BUYSELLADS = "fa-buysellads";
    const FA_CALCULATOR = "fa-calculator";
    const FA_CALENDAR = "fa-calendar";
    const FA_CALENDAR_CHECK_O = "fa-calendar-check-o";
    const FA_CALENDAR_MINUS_O = "fa-calendar-minus-o";
    const FA_CALENDAR_O = "fa-calendar-o";
    const FA_CALENDAR_PLUS_O = "fa-calendar-plus-o";
    const FA_CALENDAR_TIMES_O = "fa-calendar-times-o";
    const FA_CAMERA = "fa-camera";
    const FA_CAMERA_RETRO = "fa-camera-retro";
    const FA_CAR = "fa-car";
    const FA_CARET_DOWN = "fa-caret-down";
    const FA_CARET_LEFT = "fa-caret-left";
    const FA_CARET_RIGHT = "fa-caret-right";
    const FA_CARET_SQUARE_O_DOWN = "fa-caret-square-o-down";
    const FA_CARET_SQUARE_O_LEFT = "fa-caret-square-o-left";
    const FA_CARET_SQUARE_O_RIGHT = "fa-caret-square-o-right";
    const FA_CARET_SQUARE_O_UP = "fa-caret-square-o-up";
    const FA_CARET_UP = "fa-caret-up";
    const FA_CART_ARROW_DOWN = "fa-cart-arrow-down";
    const FA_CART_PLUS = "fa-cart-plus";
    const FA_CC = "fa-cc";
    const FA_CC_AMEX = "fa-cc-amex";
    const FA_CC_DINERS_CLUB = "fa-cc-diners-club";
    const FA_CC_DISCOVER = "fa-cc-discover";
    const FA_CC_JCB = "fa-cc-jcb";
    const FA_CC_MASTERCARD = "fa-cc-mastercard";
    const FA_CC_PAYPAL = "fa-cc-paypal";
    const FA_CC_STRIPE = "fa-cc-stripe";
    const FA_CC_VISA = "fa-cc-visa";
    const FA_CERTIFICATE = "fa-certificate";
    const FA_CHAIN_BROKEN = "fa-chain-broken";
    const FA_CHECK = "fa-check";
    const FA_CHECK_CIRCLE = "fa-check-circle";
    const FA_CHECK_CIRCLE_O = "fa-check-circle-o";
    const FA_CHECK_SQUARE = "fa-check-square";
    const FA_CHECK_SQUARE_O = "fa-check-square-o";
    const FA_CHEVRON_CIRCLE_DOWN = "fa-chevron-circle-down";
    const FA_CHEVRON_CIRCLE_LEFT = "fa-chevron-circle-left";
    const FA_CHEVRON_CIRCLE_RIGHT = "fa-chevron-circle-right";
    const FA_CHEVRON_CIRCLE_UP = "fa-chevron-circle-up";
    const FA_CHEVRON_DOWN = "fa-chevron-down";
    const FA_CHEVRON_LEFT = "fa-chevron-left";
    const FA_CHEVRON_RIGHT = "fa-chevron-right";
    const FA_CHEVRON_UP = "fa-chevron-up";
    const FA_CHILD = "fa-child";
    const FA_CHROME = "fa-chrome";
    const FA_CIRCLE = "fa-circle";
    const FA_CIRCLE_O = "fa-circle-o";
    const FA_CIRCLE_O_NOTCH = "fa-circle-o-notch";
    const FA_CIRCLE_THIN = "fa-circle-thin";
    const FA_CLIPBOARD = "fa-clipboard";
    const FA_CLOCK_O = "fa-clock-o";
    const FA_CLONE = "fa-clone";
    const FA_CLOUD = "fa-cloud";
    const FA_CLOUD_DOWNLOAD = "fa-cloud-download";
    const FA_CLOUD_UPLOAD = "fa-cloud-upload";
    const FA_CODE = "fa-code";
    const FA_CODE_FORK = "fa-code-fork";
    const FA_CODEPEN = "fa-codepen";
    const FA_COFFEE = "fa-coffee";
    const FA_COG = "fa-cog";
    const FA_COGS = "fa-cogs";
    const FA_COLUMNS = "fa-columns";
    const FA_COMMENT = "fa-comment";
    const FA_COMMENT_O = "fa-comment-o";
    const FA_COMMENTING = "fa-commenting";
    const FA_COMMENTING_O = "fa-commenting-o";
    const FA_COMMENTS = "fa-comments";
    const FA_COMMENTS_O = "fa-comments-o";
    const FA_COMPASS = "fa-compass";
    const FA_COMPRESS = "fa-compress";
    const FA_CONNECTDEVELOP = "fa-connectdevelop";
    const FA_CONTAO = "fa-contao";
    const FA_COPYRIGHT = "fa-copyright";
    const FA_CREATIVE_COMMONS = "fa-creative-commons";
    const FA_CREDIT_CARD = "fa-credit-card";
    const FA_CROP = "fa-crop";
    const FA_CROSSHAIRS = "fa-crosshairs";
    const FA_CSS3 = "fa-css3";
    const FA_CUBE = "fa-cube";
    const FA_CUBES = "fa-cubes";
    const FA_CUTLERY = "fa-cutlery";
    const FA_DASHCUBE = "fa-dashcube";
    const FA_DATABASE = "fa-database";
    const FA_DELICIOUS = "fa-delicious";
    const FA_DESKTOP = "fa-desktop";
    const FA_DEVIANTART = "fa-deviantart";
    const FA_DIAMOND = "fa-diamond";
    const FA_DIGG = "fa-digg";
    const FA_DOT_CIRCLE_O = "fa-dot-circle-o";
    const FA_DOWNLOAD = "fa-download";
    const FA_DRIBBBLE = "fa-dribbble";
    const FA_DROPBOX = "fa-dropbox";
    const FA_DRUPAL = "fa-drupal";
    const FA_EJECT = "fa-eject";
    const FA_ELLIPSIS_H = "fa-ellipsis-h";
    const FA_ELLIPSIS_V = "fa-ellipsis-v";
    const FA_EMPIRE = "fa-empire";
    const FA_ENVELOPE = "fa-envelope";
    const FA_ENVELOPE_O = "fa-envelope-o";
    const FA_ENVELOPE_SQUARE = "fa-envelope-square";
    const FA_ERASER = "fa-eraser";
    const FA_EUR = "fa-eur";
    const FA_EXCHANGE = "fa-exchange";
    const FA_EXCLAMATION = "fa-exclamation";
    const FA_EXCLAMATION_CIRCLE = "fa-exclamation-circle";
    const FA_EXCLAMATION_TRIANGLE = "fa-exclamation-triangle";
    const FA_EXPAND = "fa-expand";
    const FA_EXPEDITEDSSL = "fa-expeditedssl";
    const FA_EXTERNAL_LINK = "fa-external-link";
    const FA_EXTERNAL_LINK_SQUARE = "fa-external-link-square";
    const FA_EYE = "fa-eye";
    const FA_EYE_SLASH = "fa-eye-slash";
    const FA_EYEDROPPER = "fa-eyedropper";
    const FA_FACEBOOK = "fa-facebook";
    const FA_FACEBOOK_OFFICIAL = "fa-facebook-official";
    const FA_FACEBOOK_SQUARE = "fa-facebook-square";
    const FA_FAST_BACKWARD = "fa-fast-backward";
    const FA_FAST_FORWARD = "fa-fast-forward";
    const FA_FAX = "fa-fax";
    const FA_FEMALE = "fa-female";
    const FA_FIGHTER_JET = "fa-fighter-jet";
    const FA_FILE = "fa-file";
    const FA_FILE_ARCHIVE_O = "fa-file-archive-o";
    const FA_FILE_AUDIO_O = "fa-file-audio-o";
    const FA_FILE_CODE_O = "fa-file-code-o";
    const FA_FILE_EXCEL_O = "fa-file-excel-o";
    const FA_FILE_IMAGE_O = "fa-file-image-o";
    const FA_FILE_O = "fa-file-o";
    const FA_FILE_PDF_O = "fa-file-pdf-o";
    const FA_FILE_POWERPOINT_O = "fa-file-powerpoint-o";
    const FA_FILE_TEXT = "fa-file-text";
    const FA_FILE_TEXT_O = "fa-file-text-o";
    const FA_FILE_VIDEO_O = "fa-file-video-o";
    const FA_FILE_WORD_O = "fa-file-word-o";
    const FA_FILES_O = "fa-files-o";
    const FA_FILM = "fa-film";
    const FA_FILTER = "fa-filter";
    const FA_FIRE = "fa-fire";
    const FA_FIRE_EXTINGUISHER = "fa-fire-extinguisher";
    const FA_FIREFOX = "fa-firefox";
    const FA_FLAG = "fa-flag";
    const FA_FLAG_CHECKERED = "fa-flag-checkered";
    const FA_FLAG_O = "fa-flag-o";
    const FA_FLASK = "fa-flask";
    const FA_FLICKR = "fa-flickr";
    const FA_FLOPPY_O = "fa-floppy-o";
    const FA_FOLDER = "fa-folder";
    const FA_FOLDER_O = "fa-folder-o";
    const FA_FOLDER_OPEN = "fa-folder-open";
    const FA_FOLDER_OPEN_O = "fa-folder-open-o";
    const FA_FONT = "fa-font";
    const FA_FONTICONS = "fa-fonticons";
    const FA_FORUMBEE = "fa-forumbee";
    const FA_FORWARD = "fa-forward";
    const FA_FOURSQUARE = "fa-foursquare";
    const FA_FROWN_O = "fa-frown-o";
    const FA_FUTBOL_O = "fa-futbol-o";
    const FA_GAMEPAD = "fa-gamepad";
    const FA_GAVEL = "fa-gavel";
    const FA_GBP = "fa-gbp";
    const FA_GENDERLESS = "fa-genderless";
    const FA_GET_POCKET = "fa-get-pocket";
    const FA_GG = "fa-gg";
    const FA_GG_CIRCLE = "fa-gg-circle";
    const FA_GIFT = "fa-gift";
    const FA_GIT = "fa-git";
    const FA_GIT_SQUARE = "fa-git-square";
    const FA_GITHUB = "fa-github";
    const FA_GITHUB_ALT = "fa-github-alt";
    const FA_GITHUB_SQUARE = "fa-github-square";
    const FA_GLASS = "fa-glass";
    const FA_GLOBE = "fa-globe";
    const FA_GOOGLE = "fa-google";
    const FA_GOOGLE_PLUS = "fa-google-plus";
    const FA_GOOGLE_PLUS_SQUARE = "fa-google-plus-square";
    const FA_GOOGLE_WALLET = "fa-google-wallet";
    const FA_GRADUATION_CAP = "fa-graduation-cap";
    const FA_GRATIPAY = "fa-gratipay";
    const FA_H_SQUARE = "fa-h-square";
    const FA_HACKER_NEWS = "fa-hacker-news";
    const FA_HAND_LIZARD_O = "fa-hand-lizard-o";
    const FA_HAND_O_DOWN = "fa-hand-o-down";
    const FA_HAND_O_LEFT = "fa-hand-o-left";
    const FA_HAND_O_RIGHT = "fa-hand-o-right";
    const FA_HAND_O_UP = "fa-hand-o-up";
    const FA_HAND_PAPER_O = "fa-hand-paper-o";
    const FA_HAND_PEACE_O = "fa-hand-peace-o";
    const FA_HAND_POINTER_O = "fa-hand-pointer-o";
    const FA_HAND_ROCK_O = "fa-hand-rock-o";
    const FA_HAND_SCISSORS_O = "fa-hand-scissors-o";
    const FA_HAND_SPOCK_O = "fa-hand-spock-o";
    const FA_HDD_O = "fa-hdd-o";
    const FA_HEADER = "fa-header";
    const FA_HEADPHONES = "fa-headphones";
    const FA_HEART = "fa-heart";
    const FA_HEART_O = "fa-heart-o";
    const FA_HEARTBEAT = "fa-heartbeat";
    const FA_HISTORY = "fa-history";
    const FA_HOME = "fa-home";
    const FA_HOSPITAL_O = "fa-hospital-o";
    const FA_HOURGLASS = "fa-hourglass";
    const FA_HOURGLASS_END = "fa-hourglass-end";
    const FA_HOURGLASS_HALF = "fa-hourglass-half";
    const FA_HOURGLASS_O = "fa-hourglass-o";
    const FA_HOURGLASS_START = "fa-hourglass-start";
    const FA_HOUZZ = "fa-houzz";
    const FA_HTML5 = "fa-html5";
    const FA_I_CURSOR = "fa-i-cursor";
    const FA_ILS = "fa-ils";
    const FA_INBOX = "fa-inbox";
    const FA_INDENT = "fa-indent";
    const FA_INDUSTRY = "fa-industry";
    const FA_INFO = "fa-info";
    const FA_INFO_CIRCLE = "fa-info-circle";
    const FA_INR = "fa-inr";
    const FA_INSTAGRAM = "fa-instagram";
    const FA_INTERNET_EXPLORER = "fa-internet-explorer";
    const FA_IOXHOST = "fa-ioxhost";
    const FA_ITALIC = "fa-italic";
    const FA_JOOMLA = "fa-joomla";
    const FA_JPY = "fa-jpy";
    const FA_JSFIDDLE = "fa-jsfiddle";
    const FA_KEY = "fa-key";
    const FA_KEYBOARD_O = "fa-keyboard-o";
    const FA_KRW = "fa-krw";
    const FA_LANGUAGE = "fa-language";
    const FA_LAPTOP = "fa-laptop";
    const FA_LASTFM = "fa-lastfm";
    const FA_LASTFM_SQUARE = "fa-lastfm-square";
    const FA_LEAF = "fa-leaf";
    const FA_LEANPUB = "fa-leanpub";
    const FA_LEMON_O = "fa-lemon-o";
    const FA_LEVEL_DOWN = "fa-level-down";
    const FA_LEVEL_UP = "fa-level-up";
    const FA_LIFE_RING = "fa-life-ring";
    const FA_LIGHTBULB_O = "fa-lightbulb-o";
    const FA_LINE_CHART = "fa-line-chart";
    const FA_LINK = "fa-link";
    const FA_LINKEDIN = "fa-linkedin";
    const FA_LINKEDIN_SQUARE = "fa-linkedin-square";
    const FA_LINUX = "fa-linux";
    const FA_LIST = "fa-list";
    const FA_LIST_ALT = "fa-list-alt";
    const FA_LIST_OL = "fa-list-ol";
    const FA_LIST_UL = "fa-list-ul";
    const FA_LOCATION_ARROW = "fa-location-arrow";
    const FA_LOCK = "fa-lock";
    const FA_LONG_ARROW_DOWN = "fa-long-arrow-down";
    const FA_LONG_ARROW_LEFT = "fa-long-arrow-left";
    const FA_LONG_ARROW_RIGHT = "fa-long-arrow-right";
    const FA_LONG_ARROW_UP = "fa-long-arrow-up";
    const FA_MAGIC = "fa-magic";
    const FA_MAGNET = "fa-magnet";
    const FA_MALE = "fa-male";
    const FA_MAP = "fa-map";
    const FA_MAP_MARKER = "fa-map-marker";
    const FA_MAP_O = "fa-map-o";
    const FA_MAP_PIN = "fa-map-pin";
    const FA_MAP_SIGNS = "fa-map-signs";
    const FA_MARS = "fa-mars";
    const FA_MARS_DOUBLE = "fa-mars-double";
    const FA_MARS_STROKE = "fa-mars-stroke";
    const FA_MARS_STROKE_H = "fa-mars-stroke-h";
    const FA_MARS_STROKE_V = "fa-mars-stroke-v";
    const FA_MAXCDN = "fa-maxcdn";
    const FA_MEANPATH = "fa-meanpath";
    const FA_MEDIUM = "fa-medium";
    const FA_MEDKIT = "fa-medkit";
    const FA_MEH_O = "fa-meh-o";
    const FA_MERCURY = "fa-mercury";
    const FA_MICROPHONE = "fa-microphone";
    const FA_MICROPHONE_SLASH = "fa-microphone-slash";
    const FA_MINUS = "fa-minus";
    const FA_MINUS_CIRCLE = "fa-minus-circle";
    const FA_MINUS_SQUARE = "fa-minus-square";
    const FA_MINUS_SQUARE_O = "fa-minus-square-o";
    const FA_MOBILE = "fa-mobile";
    const FA_MONEY = "fa-money";
    const FA_MOON_O = "fa-moon-o";
    const FA_MOTORCYCLE = "fa-motorcycle";
    const FA_MOUSE_POINTER = "fa-mouse-pointer";
    const FA_MUSIC = "fa-music";
    const FA_NEUTER = "fa-neuter";
    const FA_NEWSPAPER_O = "fa-newspaper-o";
    const FA_OBJECT_GROUP = "fa-object-group";
    const FA_OBJECT_UNGROUP = "fa-object-ungroup";
    const FA_ODNOKLASSNIKI = "fa-odnoklassniki";
    const FA_ODNOKLASSNIKI_SQUARE = "fa-odnoklassniki-square";
    const FA_OPENCART = "fa-opencart";
    const FA_OPENID = "fa-openid";
    const FA_OPERA = "fa-opera";
    const FA_OPTIN_MONSTER = "fa-optin-monster";
    const FA_OUTDENT = "fa-outdent";
    const FA_PAGELINES = "fa-pagelines";
    const FA_PAINT_BRUSH = "fa-paint-brush";
    const FA_PAPER_PLANE = "fa-paper-plane";
    const FA_PAPER_PLANE_O = "fa-paper-plane-o";
    const FA_PAPERCLIP = "fa-paperclip";
    const FA_PARAGRAPH = "fa-paragraph";
    const FA_PAUSE = "fa-pause";
    const FA_PAW = "fa-paw";
    const FA_PAYPAL = "fa-paypal";
    const FA_PENCIL = "fa-pencil";
    const FA_PENCIL_SQUARE = "fa-pencil-square";
    const FA_PENCIL_SQUARE_O = "fa-pencil-square-o";
    const FA_PHONE = "fa-phone";
    const FA_PHONE_SQUARE = "fa-phone-square";
    const FA_PICTURE_O = "fa-picture-o";
    const FA_PIE_CHART = "fa-pie-chart";
    const FA_PIED_PIPER = "fa-pied-piper";
    const FA_PIED_PIPER_ALT = "fa-pied-piper-alt";
    const FA_PINTEREST = "fa-pinterest";
    const FA_PINTEREST_P = "fa-pinterest-p";
    const FA_PINTEREST_SQUARE = "fa-pinterest-square";
    const FA_PLANE = "fa-plane";
    const FA_PLAY = "fa-play";
    const FA_PLAY_CIRCLE = "fa-play-circle";
    const FA_PLAY_CIRCLE_O = "fa-play-circle-o";
    const FA_PLUG = "fa-plug";
    const FA_PLUS = "fa-plus";
    const FA_PLUS_CIRCLE = "fa-plus-circle";
    const FA_PLUS_SQUARE = "fa-plus-square";
    const FA_PLUS_SQUARE_O = "fa-plus-square-o";
    const FA_POWER_OFF = "fa-power-off";
    const FA_PRINT = "fa-print";
    const FA_PUZZLE_PIECE = "fa-puzzle-piece";
    const FA_QQ = "fa-qq";
    const FA_QRCODE = "fa-qrcode";
    const FA_QUESTION = "fa-question";
    const FA_QUESTION_CIRCLE = "fa-question-circle";
    const FA_QUOTE_LEFT = "fa-quote-left";
    const FA_QUOTE_RIGHT = "fa-quote-right";
    const FA_RANDOM = "fa-random";
    const FA_REBEL = "fa-rebel";
    const FA_RECYCLE = "fa-recycle";
    const FA_REDDIT = "fa-reddit";
    const FA_REDDIT_SQUARE = "fa-reddit-square";
    const FA_REFRESH = "fa-refresh";
    const FA_REGISTERED = "fa-registered";
    const FA_RENREN = "fa-renren";
    const FA_REPEAT = "fa-repeat";
    const FA_REPLY = "fa-reply";
    const FA_REPLY_ALL = "fa-reply-all";
    const FA_RETWEET = "fa-retweet";
    const FA_ROAD = "fa-road";
    const FA_ROCKET = "fa-rocket";
    const FA_RSS = "fa-rss";
    const FA_RSS_SQUARE = "fa-rss-square";
    const FA_RUB = "fa-rub";
    const FA_SAFARI = "fa-safari";
    const FA_SCISSORS = "fa-scissors";
    const FA_SEARCH = "fa-search";
    const FA_SEARCH_MINUS = "fa-search-minus";
    const FA_SEARCH_PLUS = "fa-search-plus";
    const FA_SELLSY = "fa-sellsy";
    const FA_SERVER = "fa-server";
    const FA_SHARE = "fa-share";
    const FA_SHARE_ALT = "fa-share-alt";
    const FA_SHARE_ALT_SQUARE = "fa-share-alt-square";
    const FA_SHARE_SQUARE = "fa-share-square";
    const FA_SHARE_SQUARE_O = "fa-share-square-o";
    const FA_SHIELD = "fa-shield";
    const FA_SHIP = "fa-ship";
    const FA_SHIRTSINBULK = "fa-shirtsinbulk";
    const FA_SHOPPING_CART = "fa-shopping-cart";
    const FA_SIGN_IN = "fa-sign-in";
    const FA_SIGN_OUT = "fa-sign-out";
    const FA_SIGNAL = "fa-signal";
    const FA_SIMPLYBUILT = "fa-simplybuilt";
    const FA_SITEMAP = "fa-sitemap";
    const FA_SKYATLAS = "fa-skyatlas";
    const FA_SKYPE = "fa-skype";
    const FA_SLACK = "fa-slack";
    const FA_SLIDERS = "fa-sliders";
    const FA_SLIDESHARE = "fa-slideshare";
    const FA_SMILE_O = "fa-smile-o";
    const FA_SORT = "fa-sort";
    const FA_SORT_ALPHA_ASC = "fa-sort-alpha-asc";
    const FA_SORT_ALPHA_DESC = "fa-sort-alpha-desc";
    const FA_SORT_AMOUNT_ASC = "fa-sort-amount-asc";
    const FA_SORT_AMOUNT_DESC = "fa-sort-amount-desc";
    const FA_SORT_ASC = "fa-sort-asc";
    const FA_SORT_DESC = "fa-sort-desc";
    const FA_SORT_NUMERIC_ASC = "fa-sort-numeric-asc";
    const FA_SORT_NUMERIC_DESC = "fa-sort-numeric-desc";
    const FA_SOUNDCLOUD = "fa-soundcloud";
    const FA_SPACE_SHUTTLE = "fa-space-shuttle";
    const FA_SPINNER = "fa-spinner";
    const FA_SPOON = "fa-spoon";
    const FA_SPOTIFY = "fa-spotify";
    const FA_SQUARE = "fa-square";
    const FA_SQUARE_O = "fa-square-o";
    const FA_STACK_EXCHANGE = "fa-stack-exchange";
    const FA_STACK_OVERFLOW = "fa-stack-overflow";
    const FA_STAR = "fa-star";
    const FA_STAR_HALF = "fa-star-half";
    const FA_STAR_HALF_O = "fa-star-half-o";
    const FA_STAR_O = "fa-star-o";
    const FA_STEAM = "fa-steam";
    const FA_STEAM_SQUARE = "fa-steam-square";
    const FA_STEP_BACKWARD = "fa-step-backward";
    const FA_STEP_FORWARD = "fa-step-forward";
    const FA_STETHOSCOPE = "fa-stethoscope";
    const FA_STICKY_NOTE = "fa-sticky-note";
    const FA_STICKY_NOTE_O = "fa-sticky-note-o";
    const FA_STOP = "fa-stop";
    const FA_STREET_VIEW = "fa-street-view";
    const FA_STRIKETHROUGH = "fa-strikethrough";
    const FA_STUMBLEUPON = "fa-stumbleupon";
    const FA_STUMBLEUPON_CIRCLE = "fa-stumbleupon-circle";
    const FA_SUBSCRIPT = "fa-subscript";
    const FA_SUBWAY = "fa-subway";
    const FA_SUITCASE = "fa-suitcase";
    const FA_SUN_O = "fa-sun-o";
    const FA_SUPERSCRIPT = "fa-superscript";
    const FA_TABLE = "fa-table";
    const FA_TABLET = "fa-tablet";
    const FA_TACHOMETER = "fa-tachometer";
    const FA_TAG = "fa-tag";
    const FA_TAGS = "fa-tags";
    const FA_TASKS = "fa-tasks";
    const FA_TAXI = "fa-taxi";
    const FA_TELEVISION = "fa-television";
    const FA_TENCENT_WEIBO = "fa-tencent-weibo";
    const FA_TERMINAL = "fa-terminal";
    const FA_TEXT_HEIGHT = "fa-text-height";
    const FA_TEXT_WIDTH = "fa-text-width";
    const FA_TH = "fa-th";
    const FA_TH_LARGE = "fa-th-large";
    const FA_TH_LIST = "fa-th-list";
    const FA_THUMB_TACK = "fa-thumb-tack";
    const FA_THUMBS_DOWN = "fa-thumbs-down";
    const FA_THUMBS_O_DOWN = "fa-thumbs-o-down";
    const FA_THUMBS_O_UP = "fa-thumbs-o-up";
    const FA_THUMBS_UP = "fa-thumbs-up";
    const FA_TICKET = "fa-ticket";
    const FA_TIMES = "fa-times";
    const FA_TIMES_CIRCLE = "fa-times-circle";
    const FA_TIMES_CIRCLE_O = "fa-times-circle-o";
    const FA_TINT = "fa-tint";
    const FA_TOGGLE_OFF = "fa-toggle-off";
    const FA_TOGGLE_ON = "fa-toggle-on";
    const FA_TRADEMARK = "fa-trademark";
    const FA_TRAIN = "fa-train";
    const FA_TRANSGENDER = "fa-transgender";
    const FA_TRANSGENDER_ALT = "fa-transgender-alt";
    const FA_TRASH = "fa-trash";
    const FA_TRASH_O = "fa-trash-o";
    const FA_TREE = "fa-tree";
    const FA_TRELLO = "fa-trello";
    const FA_TRIPADVISOR = "fa-tripadvisor";
    const FA_TROPHY = "fa-trophy";
    const FA_TRUCK = "fa-truck";
    const FA_TRY = "fa-try";
    const FA_TTY = "fa-tty";
    const FA_TUMBLR = "fa-tumblr";
    const FA_TUMBLR_SQUARE = "fa-tumblr-square";
    const FA_TWITCH = "fa-twitch";
    const FA_TWITTER = "fa-twitter";
    const FA_TWITTER_SQUARE = "fa-twitter-square";
    const FA_UMBRELLA = "fa-umbrella";
    const FA_UNDERLINE = "fa-underline";
    const FA_UNDO = "fa-undo";
    const FA_UNIVERSITY = "fa-university";
    const FA_UNLOCK = "fa-unlock";
    const FA_UNLOCK_ALT = "fa-unlock-alt";
    const FA_UPLOAD = "fa-upload";
    const FA_USD = "fa-usd";
    const FA_USER = "fa-user";
    const FA_USER_MD = "fa-user-md";
    const FA_USER_PLUS = "fa-user-plus";
    const FA_USER_SECRET = "fa-user-secret";
    const FA_USER_TIMES = "fa-user-times";
    const FA_USERS = "fa-users";
    const FA_VENUS = "fa-venus";
    const FA_VENUS_DOUBLE = "fa-venus-double";
    const FA_VENUS_MARS = "fa-venus-mars";
    const FA_VIACOIN = "fa-viacoin";
    const FA_VIDEO_CAMERA = "fa-video-camera";
    const FA_VIMEO = "fa-vimeo";
    const FA_VIMEO_SQUARE = "fa-vimeo-square";
    const FA_VINE = "fa-vine";
    const FA_VK = "fa-vk";
    const FA_VOLUME_DOWN = "fa-volume-down";
    const FA_VOLUME_OFF = "fa-volume-off";
    const FA_VOLUME_UP = "fa-volume-up";
    const FA_WEIBO = "fa-weibo";
    const FA_WEIXIN = "fa-weixin";
    const FA_WHATSAPP = "fa-whatsapp";
    const FA_WHEELCHAIR = "fa-wheelchair";
    const FA_WIFI = "fa-wifi";
    const FA_WIKIPEDIA_W = "fa-wikipedia-w";
    const FA_WINDOWS = "fa-windows";
    const FA_WORDPRESS = "fa-wordpress";
    const FA_WRENCH = "fa-wrench";
    const FA_XING = "fa-xing";
    const FA_XING_SQUARE = "fa-xing-square";
    const FA_Y_COMBINATOR = "fa-y-combinator";
    const FA_YAHOO = "fa-yahoo";
    const FA_YELP = "fa-yelp";
    const FA_YOUTUBE = "fa-youtube";
    const FA_YOUTUBE_PLAY = "fa-youtube-play";
    const FA_YOUTUBE_SQUARE = "fa-youtube-square";

    /**
     * @param string $name
     * @return string
     */
    public static function widget($name ="fa-adjust"){
        return  <<<HTML
        <svg class='{$name}'>
            <use xlink:href='#{$name}'></use>
        </svg>
HTML;
    }

    /**
     * 获取所有名称
     * @return array
     */
    public static function getIconsNames()
    {
        return ['fa-500px', 'fa-adjust', 'fa-adn', 'fa-align-center', 'fa-align-justify', 'fa-align-left',
            'fa-align-right', 'fa-amazon', 'fa-ambulance', 'fa-anchor', 'fa-android', 'fa-angellist',
            'fa-angle-double-down', 'fa-angle-double-left', 'fa-angle-double-right', 'fa-angle-double-up',
            'fa-angle-down', 'fa-angle-left', 'fa-angle-right', 'fa-angle-up', 'fa-apple', 'fa-archive', 'fa-area-chart',
            'fa-arrow-circle-down', 'fa-arrow-circle-left', 'fa-arrow-circle-o-down', 'fa-arrow-circle-o-left',
            'fa-arrow-circle-o-right', 'fa-arrow-circle-o-up', 'fa-arrow-circle-right', 'fa-arrow-circle-up',
            'fa-arrow-down', 'fa-arrow-left', 'fa-arrow-right', 'fa-arrow-up', 'fa-arrows', 'fa-arrows-alt', 'fa-arrows-h',
            'fa-arrows-v', 'fa-asterisk', 'fa-at', 'fa-backward', 'fa-balance-scale', 'fa-ban', 'fa-bar-chart',
            'fa-barcode', 'fa-bars', 'fa-battery-empty', 'fa-battery-full', 'fa-battery-half', 'fa-battery-quarter',
            'fa-battery-three-quarters', 'fa-bed', 'fa-beer', 'fa-behance', 'fa-behance-square', 'fa-bell', 'fa-bell-o',
            'fa-bell-slash', 'fa-bell-slash-o', 'fa-bicycle', 'fa-binoculars', 'fa-birthday-cake', 'fa-bitbucket',
            'fa-bitbucket-square', 'fa-black-tie', 'fa-bold', 'fa-bolt', 'fa-bomb', 'fa-book', 'fa-bookmark', 'fa-bookmark-o',
            'fa-briefcase', 'fa-btc', 'fa-bug', 'fa-building', 'fa-building-o', 'fa-bullhorn', 'fa-bullseye', 'fa-bus',
            'fa-buysellads', 'fa-calculator', 'fa-calendar', 'fa-calendar-check-o', 'fa-calendar-minus-o', 'fa-calendar-o',
            'fa-calendar-plus-o', 'fa-calendar-times-o', 'fa-camera', 'fa-camera-retro', 'fa-car', 'fa-caret-down',
            'fa-caret-left', 'fa-caret-right', 'fa-caret-square-o-down', 'fa-caret-square-o-left', 'fa-caret-square-o-right',
            'fa-caret-square-o-up', 'fa-caret-up', 'fa-cart-arrow-down', 'fa-cart-plus', 'fa-cc', 'fa-cc-amex', 'fa-cc-diners-club',
            'fa-cc-discover', 'fa-cc-jcb', 'fa-cc-mastercard', 'fa-cc-paypal', 'fa-cc-stripe', 'fa-cc-visa', 'fa-certificate',
            'fa-chain-broken', 'fa-check', 'fa-check-circle', 'fa-check-circle-o', 'fa-check-square', 'fa-check-square-o',
            'fa-chevron-circle-down', 'fa-chevron-circle-left', 'fa-chevron-circle-right', 'fa-chevron-circle-up', 'fa-chevron-down',
            'fa-chevron-left', 'fa-chevron-right', 'fa-chevron-up', 'fa-child', 'fa-chrome', 'fa-circle', 'fa-circle-o',
            'fa-circle-o-notch', 'fa-circle-thin', 'fa-clipboard', 'fa-clock-o', 'fa-clone', 'fa-cloud', 'fa-cloud-download',
            'fa-cloud-upload', 'fa-code', 'fa-code-fork', 'fa-codepen', 'fa-coffee', 'fa-cog', 'fa-cogs', 'fa-columns', 'fa-comment',
            'fa-comment-o', 'fa-commenting', 'fa-commenting-o', 'fa-comments', 'fa-comments-o', 'fa-compass', 'fa-compress',
            'fa-connectdevelop', 'fa-contao', 'fa-copyright', 'fa-creative-commons', 'fa-credit-card', 'fa-crop', 'fa-crosshairs',
            'fa-css3', 'fa-cube', 'fa-cubes', 'fa-cutlery', 'fa-dashcube', 'fa-database', 'fa-delicious', 'fa-desktop',
            'fa-deviantart', 'fa-diamond', 'fa-digg', 'fa-dot-circle-o', 'fa-download', 'fa-dribbble', 'fa-dropbox', 'fa-drupal',
            'fa-eject', 'fa-ellipsis-h', 'fa-ellipsis-v', 'fa-empire', 'fa-envelope', 'fa-envelope-o', 'fa-envelope-square',
            'fa-eraser', 'fa-eur', 'fa-exchange', 'fa-exclamation', 'fa-exclamation-circle', 'fa-exclamation-triangle',
            'fa-expand', 'fa-expeditedssl', 'fa-external-link', 'fa-external-link-square', 'fa-eye', 'fa-eye-slash', 'fa-eyedropper',
            'fa-facebook', 'fa-facebook-official', 'fa-facebook-square', 'fa-fast-backward', 'fa-fast-forward', 'fa-fax', 'fa-female',
            'fa-fighter-jet',
            'fa-file', 'fa-file-archive-o', 'fa-file-audio-o', 'fa-file-code-o', 'fa-file-excel-o', 'fa-file-image-o', 'fa-file-o',
            'fa-file-pdf-o', 'fa-file-powerpoint-o', 'fa-file-text', 'fa-file-text-o', 'fa-file-video-o', 'fa-file-word-o', 'fa-files-o',
            'fa-film', 'fa-filter', 'fa-fire', 'fa-fire-extinguisher', 'fa-firefox', 'fa-flag', 'fa-flag-checkered', 'fa-flag-o', 'fa-flask',
            'fa-flickr', 'fa-floppy-o', 'fa-folder', 'fa-folder-o', 'fa-folder-open', 'fa-folder-open-o', 'fa-font',
            'fa-fonticons', 'fa-forumbee', 'fa-forward', 'fa-foursquare', 'fa-frown-o', 'fa-futbol-o', 'fa-gamepad', 'fa-gavel',
            'fa-gbp', 'fa-genderless', 'fa-get-pocket', 'fa-gg', 'fa-gg-circle', 'fa-gift', 'fa-git', 'fa-git-square', 'fa-github',
            'fa-github-alt', 'fa-github-square', 'fa-glass', 'fa-globe', 'fa-google', 'fa-google-plus', 'fa-google-plus-square',
            'fa-google-wallet', 'fa-graduation-cap', 'fa-gratipay', 'fa-h-square', 'fa-hacker-news', 'fa-hand-lizard-o', 'fa-hand-o-down',
            'fa-hand-o-left', 'fa-hand-o-right', 'fa-hand-o-up', 'fa-hand-paper-o', 'fa-hand-peace-o', 'fa-hand-pointer-o',
            'fa-hand-rock-o', 'fa-hand-scissors-o', 'fa-hand-spock-o', 'fa-hdd-o', 'fa-header', 'fa-headphones', 'fa-heart',
            'fa-heart-o', 'fa-heartbeat', 'fa-history', 'fa-home', 'fa-hospital-o', 'fa-hourglass', 'fa-hourglass-end',
            'fa-hourglass-half', 'fa-hourglass-o', 'fa-hourglass-start', 'fa-houzz', 'fa-html5', 'fa-i-cursor', 'fa-ils',
            'fa-inbox', 'fa-indent', 'fa-industry', 'fa-info', 'fa-info-circle', 'fa-inr', 'fa-instagram', 'fa-internet-explorer',
            'fa-ioxhost', 'fa-italic', 'fa-joomla', 'fa-jpy', 'fa-jsfiddle', 'fa-key', 'fa-keyboard-o', 'fa-krw', 'fa-language',
            'fa-laptop', 'fa-lastfm', 'fa-lastfm-square', 'fa-leaf', 'fa-leanpub', 'fa-lemon-o', 'fa-level-down', 'fa-level-up',
            'fa-life-ring', 'fa-lightbulb-o', 'fa-line-chart', 'fa-link', 'fa-linkedin', 'fa-linkedin-square', 'fa-linux', 'fa-list',
            'fa-list-alt', 'fa-list-ol', 'fa-list-ul', 'fa-location-arrow', 'fa-lock', 'fa-long-arrow-down', 'fa-long-arrow-left',
            'fa-long-arrow-right', 'fa-long-arrow-up', 'fa-magic', 'fa-magnet', 'fa-male', 'fa-map', 'fa-map-marker', 'fa-map-o',
            'fa-map-pin', 'fa-map-signs', 'fa-mars', 'fa-mars-double', 'fa-mars-stroke', 'fa-mars-stroke-h', 'fa-mars-stroke-v',
            'fa-maxcdn', 'fa-meanpath', 'fa-medium', 'fa-medkit', 'fa-meh-o', 'fa-mercury', 'fa-microphone', 'fa-microphone-slash',
            'fa-minus', 'fa-minus-circle', 'fa-minus-square', 'fa-minus-square-o', 'fa-mobile', 'fa-money', 'fa-moon-o',
            'fa-motorcycle', 'fa-mouse-pointer', 'fa-music', 'fa-neuter', 'fa-newspaper-o', 'fa-object-group', 'fa-object-ungroup',
            'fa-odnoklassniki', 'fa-odnoklassniki-square', 'fa-opencart', 'fa-openid', 'fa-opera', 'fa-optin-monster', 'fa-outdent',
            'fa-pagelines', 'fa-paint-brush', 'fa-paper-plane', 'fa-paper-plane-o', 'fa-paperclip', 'fa-paragraph', 'fa-pause',
            'fa-paw', 'fa-paypal', 'fa-pencil', 'fa-pencil-square', 'fa-pencil-square-o', 'fa-phone', 'fa-phone-square', 'fa-picture-o',
            'fa-pie-chart', 'fa-pied-piper', 'fa-pied-piper-alt', 'fa-pinterest', 'fa-pinterest-p', 'fa-pinterest-square',
            'fa-plane', 'fa-play', 'fa-play-circle', 'fa-play-circle-o', 'fa-plug', 'fa-plus', 'fa-plus-circle', 'fa-plus-square',
            'fa-plus-square-o', 'fa-power-off', 'fa-print', 'fa-puzzle-piece', 'fa-qq', 'fa-qrcode', 'fa-question',
            'fa-question-circle', 'fa-quote-left', 'fa-quote-right', 'fa-random', 'fa-rebel', 'fa-recycle', 'fa-reddit',
            'fa-reddit-square', 'fa-refresh', 'fa-registered', 'fa-renren', 'fa-repeat', 'fa-reply', 'fa-reply-all',
            'fa-retweet', 'fa-road', 'fa-rocket', 'fa-rss', 'fa-rss-square', 'fa-rub', 'fa-safari', 'fa-scissors',
            'fa-search', 'fa-search-minus', 'fa-search-plus', 'fa-sellsy', 'fa-server', 'fa-share', 'fa-share-alt',
            'fa-share-alt-square', 'fa-share-square', 'fa-share-square-o', 'fa-shield', 'fa-ship', 'fa-shirtsinbulk',
            'fa-shopping-cart', 'fa-sign-in', 'fa-sign-out', 'fa-signal', 'fa-simplybuilt', 'fa-sitemap', 'fa-skyatlas',
            'fa-skype', 'fa-slack', 'fa-sliders', 'fa-slideshare', 'fa-smile-o', 'fa-sort', 'fa-sort-alpha-asc', 'fa-sort-alpha-desc',
            'fa-sort-amount-asc', 'fa-sort-amount-desc', 'fa-sort-asc', 'fa-sort-desc', 'fa-sort-numeric-asc', 'fa-sort-numeric-desc',
            'fa-soundcloud', 'fa-space-shuttle', 'fa-spinner', 'fa-spoon', 'fa-spotify', 'fa-square', 'fa-square-o', 'fa-stack-exchange',
            'fa-stack-overflow', 'fa-star', 'fa-star-half', 'fa-star-half-o', 'fa-star-o', 'fa-steam', 'fa-steam-square', 'fa-step-backward',
            'fa-step-forward', 'fa-stethoscope', 'fa-sticky-note', 'fa-sticky-note-o', 'fa-stop', 'fa-street-view', 'fa-strikethrough',
            'fa-stumbleupon', 'fa-stumbleupon-circle', 'fa-subscript', 'fa-subway', 'fa-suitcase', 'fa-sun-o', 'fa-superscript',
            'fa-table', 'fa-tablet', 'fa-tachometer', 'fa-tag', 'fa-tags', 'fa-tasks', 'fa-taxi', 'fa-television', 'fa-tencent-weibo',
            'fa-terminal', 'fa-text-height', 'fa-text-width', 'fa-th', 'fa-th-large', 'fa-th-list', 'fa-thumb-tack', 'fa-thumbs-down',
            'fa-thumbs-o-down', 'fa-thumbs-o-up', 'fa-thumbs-up', 'fa-ticket', 'fa-times', 'fa-times-circle', 'fa-times-circle-o',
            'fa-tint', 'fa-toggle-off', 'fa-toggle-on', 'fa-trademark', 'fa-train', 'fa-transgender', 'fa-transgender-alt',
            'fa-trash', 'fa-trash-o', 'fa-tree', 'fa-trello', 'fa-tripadvisor', 'fa-trophy', 'fa-truck', 'fa-try', 'fa-tty',
            'fa-tumblr', 'fa-tumblr-square', 'fa-twitch', 'fa-twitter', 'fa-twitter-square', 'fa-umbrella', 'fa-underline',
            'fa-undo', 'fa-university', 'fa-unlock', 'fa-unlock-alt', 'fa-upload', 'fa-usd', 'fa-user', 'fa-user-md',
            'fa-user-plus', 'fa-user-secret', 'fa-user-times', 'fa-users', 'fa-venus', 'fa-venus-double', 'fa-venus-mars',
            'fa-viacoin', 'fa-video-camera', 'fa-vimeo', 'fa-vimeo-square', 'fa-vine', 'fa-vk', 'fa-volume-down', 'fa-volume-off',
            'fa-volume-up', 'fa-weibo', 'fa-weixin', 'fa-whatsapp', 'fa-wheelchair', 'fa-wifi', 'fa-wikipedia-w', 'fa-windows',
            'fa-wordpress', 'fa-wrench', 'fa-xing', 'fa-xing-square', 'fa-y-combinator', 'fa-yahoo', 'fa-yelp', 'fa-youtube',
            'fa-youtube-play', 'fa-youtube-square'
        ];
    }
}