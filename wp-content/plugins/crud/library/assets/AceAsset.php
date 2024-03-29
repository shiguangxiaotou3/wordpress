<?php


namespace crud\assets;


class AceAsset extends AppAsset {

    public $sourcePath =  "@bower/ace";
    public $css = [];
    public $js = [
        'src/ace.js',"src/ext-settings_menu.js"
    ];
    public $jsOptions=[
    ];
    public $depends =['yii\web\JqueryAsset'];

    const MODE_GITIGNORE = 'ace/mode/gitignore';
    const MODE_D = 'ace/mode/d';
    const MODE_HAML = 'ace/mode/haml';
    const MODE_JACK = 'ace/mode/jack';
    const MODE_PASCAL = 'ace/mode/pascal';
    const MODE_RED = 'ace/mode/red';
    const MODE_POWERSHELL = 'ace/mode/powershell';
    const MODE_TYPESCRIPT = 'ace/mode/typescript';
    const MODE_TURTLE = 'ace/mode/turtle';
    const MODE_HTML = 'ace/mode/html';
    const MODE_EIFFEL = 'ace/mode/eiffel';
    const MODE_STYLUS = 'ace/mode/stylus';
    const MODE_CSP = 'ace/mode/csp';
    const MODE_IO = 'ace/mode/io';
    const MODE_CSHARP = 'ace/mode/csharp';
    const MODE_PERL = 'ace/mode/perl';
    const MODE_ELIXIR = 'ace/mode/elixir';
    const MODE_VHDL = 'ace/mode/vhdl';
    const MODE_XML = 'ace/mode/xml';
    const MODE_SH = 'ace/mode/sh';
    const MODE_SLIM = 'ace/mode/slim';
    const MODE_COBOL = 'ace/mode/cobol';
    const MODE_GRAPHQLSCHEMA = 'ace/mode/graphqlschema';
    const MODE_PUPPET = 'ace/mode/puppet';
    const MODE_APACHE_CONF = 'ace/mode/apache_conf';
    const MODE_LIVESCRIPT = 'ace/mode/livescript';
    const MODE_MIXAL = 'ace/mode/mixal';
    const MODE_VERILOG = 'ace/mode/verilog';
    const MODE_GOLANG = 'ace/mode/golang';
    const MODE_OCAML = 'ace/mode/ocaml';
    const MODE_KOTLIN = 'ace/mode/kotlin';
    const MODE_ZEEK = 'ace/mode/zeek';
    const MODE_JSX = 'ace/mode/jsx';
    const MODE_DART = 'ace/mode/dart';
    const MODE_PYTHON = 'ace/mode/python';
    const MODE_RUBY = 'ace/mode/ruby';
    const MODE_SASS = 'ace/mode/sass';
    const MODE_C9SEARCH = 'ace/mode/c9search';
    const MODE_ACTIONSCRIPT = 'ace/mode/actionscript';
    const MODE_COFFEE = 'ace/mode/coffee';
    const MODE_COLDFUSION = 'ace/mode/coldfusion';
    const MODE_CIRRU = 'ace/mode/cirru';
    const MODE_ION = 'ace/mode/ion';
    const MODE_OBJECTIVEC = 'ace/mode/objectivec';
    const MODE_APEX = 'ace/mode/apex';
    const MODE_TSX = 'ace/mode/tsx';
    const MODE_RHTML = 'ace/mode/rhtml';
    const MODE_TEX = 'ace/mode/tex';
    const MODE_RAKU = 'ace/mode/raku';
    const MODE_EJS = 'ace/mode/ejs';
    const MODE_JSONIQ = 'ace/mode/jsoniq';
    const MODE_CRYSTAL = 'ace/mode/crystal';
    const MODE_MUSHCODE = 'ace/mode/mushcode';
    const MODE_NIX = 'ace/mode/nix';
    const MODE_JAVA = 'ace/mode/java';
    const MODE_R = 'ace/mode/r';
    const MODE_HASKELL_CABAL = 'ace/mode/haskell_cabal';
    const MODE_C_CPP = 'ace/mode/c_cpp';
    const MODE_GLSL = 'ace/mode/glsl';
    const MODE_MASK = 'ace/mode/mask';
    const MODE_GHERKIN = 'ace/mode/gherkin';
    const MODE_BIBTEX = 'ace/mode/bibtex';
    const MODE_PLAIN_TEXT = 'ace/mode/plain_text';
    const MODE_ASSEMBLY_X86 = 'ace/mode/assembly_x86';
    const MODE_SCHEME = 'ace/mode/scheme';
    const MODE_PHP_LARAVEL_BLADE = 'ace/mode/php_laravel_blade';
    const MODE_LISP = 'ace/mode/lisp';
    const MODE_WOLLOK = 'ace/mode/wollok';
    const MODE_HANDLEBARS = 'ace/mode/handlebars';
    const MODE_GROOVY = 'ace/mode/groovy';
    const MODE_ADA = 'ace/mode/ada';
    const MODE_PROPERTIES = 'ace/mode/properties';
    const MODE_PRISMA = 'ace/mode/prisma';
    const MODE_CURLY = 'ace/mode/curly';
    const MODE_REDSHIFT = 'ace/mode/redshift';
    const MODE_PGSQL = 'ace/mode/pgsql';
    const MODE_JADE = 'ace/mode/jade';
    const MODE_LUA = 'ace/mode/lua';
    const MODE_BATCHFILE = 'ace/mode/batchfile';
    const MODE_LUCENE = 'ace/mode/lucene';
    const MODE_FTL = 'ace/mode/ftl';
    const MODE_ABC = 'ace/mode/abc';
    const MODE_NGINX = 'ace/mode/nginx';
    const MODE_NSIS = 'ace/mode/nsis';
    const MODE_SPARQL = 'ace/mode/sparql';
    const MODE_JSSM = 'ace/mode/jssm';
    const MODE_ABAP = 'ace/mode/abap';
    const MODE_RDOC = 'ace/mode/rdoc';
    const MODE_NUNJUCKS = 'ace/mode/nunjucks';
    const MODE_DJANGO = 'ace/mode/django';
    const MODE_HASKELL = 'ace/mode/haskell';
    const MODE_FORTRAN = 'ace/mode/fortran';
    const MODE_RST = 'ace/mode/rst';
    const MODE_LOGTALK = 'ace/mode/logtalk';
    const MODE_JAVASCRIPT = 'ace/mode/javascript';
    const MODE_VELOCITY = 'ace/mode/velocity';
    const MODE_TEXTILE = 'ace/mode/textile';
    const MODE_CSOUND_DOCUMENT = 'ace/mode/csound_document';
    const MODE_LESS = 'ace/mode/less';
    const MODE_FORTH = 'ace/mode/forth';
    const MODE_DROOLS = 'ace/mode/drools';
    const MODE_JEXL = 'ace/mode/jexl';
    const MODE_AUTOHOTKEY = 'ace/mode/autohotkey';
    const MODE_ELM = 'ace/mode/elm';
    const MODE_JSP = 'ace/mode/jsp';
    const MODE_VISUALFORCE = 'ace/mode/visualforce';
    const MODE_CLOJURE = 'ace/mode/clojure';
    const MODE_RUST = 'ace/mode/rust';
    const MODE_PARTIQL = 'ace/mode/partiql';
    const MODE_PROTOBUF = 'ace/mode/protobuf';
    const MODE_TERRAFORM = 'ace/mode/terraform';
    const MODE_SCAD = 'ace/mode/scad';
    const MODE_SQLSERVER = 'ace/mode/sqlserver';
    const MODE_FSL = 'ace/mode/fsl';
    const MODE_ERLANG = 'ace/mode/erlang';
    const MODE_QML = 'ace/mode/qml';
    const MODE_TOML = 'ace/mode/toml';
    const MODE_DOT = 'ace/mode/dot';
    const MODE_XQUERY = 'ace/mode/xquery';
    const MODE_SJS = 'ace/mode/sjs';
    const MODE_JSON = 'ace/mode/json';
    const MODE_SWIFT = 'ace/mode/swift';
    const MODE_HAXE = 'ace/mode/haxe';
    const MODE_ASCIIDOC = 'ace/mode/asciidoc';
    const MODE_PHP = 'ace/mode/php';
    const MODE_SMITHY = 'ace/mode/smithy';
    const MODE_MEDIAWIKI = 'ace/mode/mediawiki';
    const MODE_SQL = 'ace/mode/sql';
    const MODE_INI = 'ace/mode/ini';
    const MODE_PROLOG = 'ace/mode/prolog';
    const MODE_LUAPAGE = 'ace/mode/luapage';
    const MODE_ASL = 'ace/mode/asl';
    const MODE_LIQUID = 'ace/mode/liquid';
    const MODE_LATTE = 'ace/mode/latte';
    const MODE_TWIG = 'ace/mode/twig';
    const MODE_LATEX = 'ace/mode/latex';
    const MODE_JULIA = 'ace/mode/julia';
    const MODE_CSOUND_SCORE = 'ace/mode/csound_score';
    const MODE_ALDA = 'ace/mode/alda';
    const MODE_MAZE = 'ace/mode/maze';
    const MODE_SNIPPETS = 'ace/mode/snippets';
    const MODE_HJSON = 'ace/mode/hjson';
    const MODE_MIPS = 'ace/mode/mips';
    const MODE_MAKEFILE = 'ace/mode/makefile';
    const MODE_ROBOT = 'ace/mode/robot';
    const MODE_VALA = 'ace/mode/vala';
    const MODE_RAZOR = 'ace/mode/razor';
    const MODE_SOY_TEMPLATE = 'ace/mode/soy_template';
    const MODE_JSON5 = 'ace/mode/json5';
    const MODE_PRAAT = 'ace/mode/praat';
    const MODE_PIG = 'ace/mode/pig';
    const MODE_YAML = 'ace/mode/yaml';
    const MODE_AQL = 'ace/mode/aql';
    const MODE_MEL = 'ace/mode/mel';
    const MODE_APPLESCRIPT = 'ace/mode/applescript';
    const MODE_HTML_RUBY = 'ace/mode/html_ruby';
    const MODE_SPACE = 'ace/mode/space';
    const MODE_MARKDOWN = 'ace/mode/markdown';
    const MODE_TCL = 'ace/mode/tcl';
    const MODE_GCODE = 'ace/mode/gcode';
    const MODE_HTML_ELIXIR = 'ace/mode/html_elixir';
    const MODE_SVG = 'ace/mode/svg';
    const MODE_MATLAB = 'ace/mode/matlab';
    const MODE_SCALA = 'ace/mode/scala';
    const MODE_CSOUND_ORCHESTRA = 'ace/mode/csound_orchestra';
    const MODE_DIFF = 'ace/mode/diff';
    const MODE_VBSCRIPT = 'ace/mode/vbscript';
    const MODE_FSHARP = 'ace/mode/fsharp';
    const MODE_LSL = 'ace/mode/lsl';
    const MODE_NIM = 'ace/mode/nim';
    const MODE_MYSQL = 'ace/mode/mysql';
    const MODE_SCSS = 'ace/mode/scss';
    const MODE_GOBSTONES = 'ace/mode/gobstones';
    const MODE_CSS = 'ace/mode/css';
    const MODE_SCRYPT = 'ace/mode/scrypt';
    const MODE_SMARTY = 'ace/mode/smarty';
    const MODE_SAC = 'ace/mode/sac';
    const MODE_LOGIQL = 'ace/mode/logiql';
    const MODE_DOCKERFILE = 'ace/mode/dockerfile';
    const MODE_TEXT = 'ace/mode/text';
    const MODE_EDIFACT = 'ace/mode/edifact';
    const EXT_EMMET = 'ace/ext/emmet';
    const EXT_TEXTAREA = 'ace/ext/textarea';
    const EXT_ERROR_MARKER = 'ace/ext/error_marker';
    const EXT_SEARCHBOX = 'ace/ext/searchbox';
    const EXT_STATIC_HIGHLIGHT = 'ace/ext/static_highlight';
    const EXT_CODE_LENS = 'ace/ext/code_lens';
    const EXT_SPELLCHECK = 'ace/ext/spellcheck';
    const EXT_PROMPT = 'ace/ext/prompt';
    const EXT_HARDWRAP = 'ace/ext/hardwrap';
    const EXT_LINKING = 'ace/ext/linking';
    const EXT_MODELIST = 'ace/ext/modelist';
    const EXT_BEAUTIFY = 'ace/ext/beautify';
    const EXT_THEMELIST = 'ace/ext/themelist';
    const EXT_LANGUAGE_TOOLS = 'ace/ext/language_tools';
    const EXT_STATUSBAR = 'ace/ext/statusbar';
    const EXT_ELASTIC_TABSTOPS_LITE = 'ace/ext/elastic_tabstops_lite';
    const EXT_SPLIT = 'ace/ext/split';
    const EXT_OPTIONS = 'ace/ext/options';
    const EXT_KEYBINDING_MENU = 'ace/ext/keybinding_menu';
    const EXT_RTL = 'ace/ext/rtl';
    const EXT_WHITESPACE = 'ace/ext/whitespace';
    const EXT_SETTINGS_MENU = 'ace/ext/settings_menu';
    const THEME_CLOUD9_NIGHT_LOW_COLOR = 'ace/theme/cloud9_night_low_color';
    const THEME_CLOUD9_DAY = 'ace/theme/cloud9_day';
    const THEME_CLOUDS = 'ace/theme/clouds';
    const THEME_COBALT = 'ace/theme/cobalt';
    const THEME_ECLIPSE = 'ace/theme/eclipse';
    const THEME_NORD_DARK = 'ace/theme/nord_dark';
    const THEME_DAWN = 'ace/theme/dawn';
    const THEME_SOLARIZED_LIGHT = 'ace/theme/solarized_light';
    const THEME_CHAOS = 'ace/theme/chaos';
    const THEME_MONOKAI = 'ace/theme/monokai';
    const THEME_GITHUB = 'ace/theme/github';
    const THEME_MERBIVORE_SOFT = 'ace/theme/merbivore_soft';
    const THEME_KATZENMILCH = 'ace/theme/katzenmilch';
    const THEME_CHROME = 'ace/theme/chrome';
    const THEME_TOMORROW = 'ace/theme/tomorrow';
    const THEME_CLOUDS_MIDNIGHT = 'ace/theme/clouds_midnight';
    const THEME_TOMORROW_NIGHT_BLUE = 'ace/theme/tomorrow_night_blue';
    const THEME_GOB = 'ace/theme/gob';
    const THEME_GRUVBOX = 'ace/theme/gruvbox';
    const THEME_XCODE = 'ace/theme/xcode';
    const THEME_TEXTMATE = 'ace/theme/textmate';
    const THEME_IPLASTIC = 'ace/theme/iplastic';
    const THEME_CRIMSON_EDITOR = 'ace/theme/crimson_editor';
    const THEME_TOMORROW_NIGHT_BRIGHT = 'ace/theme/tomorrow_night_bright';
    const THEME_CLOUD9_NIGHT = 'ace/theme/cloud9_night';
    const THEME_MONO_INDUSTRIAL = 'ace/theme/mono_industrial';
    const THEME_MERBIVORE = 'ace/theme/merbivore';
    const THEME_SQLSERVER = 'ace/theme/sqlserver';
    const THEME_IDLE_FINGERS = 'ace/theme/idle_fingers';
    const THEME_GRUVBOX_LIGHT_HARD = 'ace/theme/gruvbox_light_hard';
    const THEME_AMBIANCE = 'ace/theme/ambiance';
    const THEME_KUROIR = 'ace/theme/kuroir';
    const THEME_PASTEL_ON_DARK = 'ace/theme/pastel_on_dark';
    const THEME_GRUVBOX_DARK_HARD = 'ace/theme/gruvbox_dark_hard';
    const THEME_KR_THEME = 'ace/theme/kr_theme';
    const THEME_TWILIGHT = 'ace/theme/twilight';
    const THEME_SOLARIZED_DARK = 'ace/theme/solarized_dark';
    const THEME_TOMORROW_NIGHT = 'ace/theme/tomorrow_night';
    const THEME_TERMINAL = 'ace/theme/terminal';
    const THEME_DRACULA = 'ace/theme/dracula';
    const THEME_ONE_DARK = 'ace/theme/one_dark';
    const THEME_VIBRANT_INK = 'ace/theme/vibrant_ink';
    const THEME_TOMORROW_NIGHT_EIGHTIES = 'ace/theme/tomorrow_night_eighties';
    const THEME_DREAMWEAVER = 'ace/theme/dreamweaver';

}

