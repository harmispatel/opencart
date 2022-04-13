<?php

use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\Permission;
use App\Models\CategoryDetail;
use App\Models\CustomerBanIp;
use App\Models\CustomerIP;
use App\Models\Option;
use App\Models\Region;
use App\Models\Settings;
use App\Models\Store;
use App\Models\Topping;
use App\Models\ToppingProductPriceSize;

// Function of User Details
function user_details()
{
    $user_dt = auth()->user();
    return $user_dt;
}


// Get Total Ip Count
function gettotalip($ip)
{
    $ip = CustomerIP::where('ip',$ip)->count();
    return $ip;
}


//
function themeActive()
{
    // Current Store ID
    $current_store_id = currentStoreId();

    $key = 'theme_id';

    $setting = Settings::select('value')->where('store_id',$current_store_id)->where('key',$key)->first();

    $theme_id = isset($setting->value) ? $setting->value : '';

    return $theme_id;

}


function themeID($url)
{
    $slash = substr($url, -1);

    if($slash != '/')
    {
        $new_url = $url .= '/';
    }
    else
    {
        $new_url = $url;
    }

    $storeDetails = Store::where('url',$new_url)->orWhere('ssl',$new_url)->first();
    $store_id = isset($storeDetails->store_id) ? $storeDetails->store_id : '';

    $key = 'theme_id';
    $setting = Settings::select('value')->where('store_id',$store_id)->where('key',$key)->first();
    $theme_id = isset($setting->value) ? $setting->value : '';

    if(session()->has('theme_id'))
    {
        session()->forget('theme_id');
        session()->put('theme_id', $theme_id);
    }
    else
    {
        session()->put('theme_id', $theme_id);
    }

}


function getFonts()
{
    $fonts = array(
		''                         => '- default -',
		'Arial'                    => 'Arial',
		'Verdana'                  => 'Verdana',
		'Helvetica'                => 'Helvetica',
		'Lucida Grande'            => 'Lucida Grande',
		'Trebuchet MS'             => 'Trebuchet MS',
		'Times New Roman'          => 'Times New Roman',
		'Tahoma'                   => 'Tahoma',
		'Georgia'                  => 'Georgia',
        'Calibri'                  => 'Calibri',

		'Abel'                     => 'Abel',
		'Abril+Fatface'            => 'Abril Fatface',
		'Aclonica'                 => 'Aclonica',
		'Acme'                     => 'Acme',
		'Actor'                    => 'Actor',
		'Adamina'                  => 'Adamina',
        'Advent+Pro'               => 'Advent Pro',
		'Aguafina+Script'          => 'Aguafina Script',
		'Aladin'                   => 'Aladin',
		'Aldrich'                  => 'Aldrich',
		'Alegreya'                 => 'Alegreya',
		'Alegreya+SC'              => 'Alegreya SC',
		'Alex+Brush'               => 'Alex Brush',
		'Alfa+Slab+One'            => 'Alfa Slab One',
		'Alice'                    => 'Alice',
		'Alike'                    => 'Alike',
		'Alike+Angular'            => 'Alike Angular',
		'Allan'                    => 'Allan',
		'Allerta'                  => 'Allerta',
		'Allerta+Stencil'          => 'Allerta Stencil',
		'Allura'                   => 'Allura',
		'Almendra'                 => 'Almendra',
		'Almendra+SC'              => 'Almendra SC',
		'Amaranth'                 => 'Amaranth',
		'Amatic+SC'                => 'Amatic SC',
		'Amethysta'                => 'Amethysta',
        'Anaheim'                  => 'Anaheim',
		'Andada'                   => 'Andada',
		'Andika'                   => 'Andika',
		'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope',
		'Anonymous+Pro'            => 'Anonymous Pro',
		'Antic'                    => 'Antic',
		'Anton'                    => 'Anton',
		'Arapey'                   => 'Arapey',
		'Architects+Daughter'      => 'Architects Daughter',
        'Archivo Narrow'           => 'Archivo Narrow',
		'Arizonia'                 => 'Arizonia',
		'Armata'                   => 'Armata',
		'Artifika'                 => 'Artifika',
		'Arvo'                     => 'Arvo',
		'Asul'                     => 'Asul',
		'Atomic+Age'               => 'Atomic Age',
		'Aubrey'                   => 'Aubrey',
        'Average'                  => 'Average',
		'Bad+Script'               => 'Bad Script',
		'Bangers'                  => 'Bangers',
		'Basic'                    => 'Basic',
		'Baumans'                  => 'Baumans',
		'Belgrano'                 => 'Belgrano',
		'Bentham'                  => 'Bentham',
		'Bevan'                    => 'Bevan',
		'Bigshot+One'              => 'Bigshot One',
		'Bilbo'                    => 'Bilbo',
		'Bilbo+Swash+Caps'         => 'Bilbo Swash Caps',
		'Bitter'                   => 'Bitter',
		'Black+Ops+One'            => 'Black Ops One',
		'Boogaloo'                 => 'Boogaloo',
		'Bowlby+One'               => 'Bowlby One',
		'Bowlby+One+SC'            => 'Bowlby One SC',
		'Brawler'                  => 'Brawler',
		'Bree+Serif'               => 'Bree Serif',
		'Bubblegum+Sans'           => 'Bubblegum Sans',
		'Buda'                     => 'Buda',
		'Buenard'                  => 'Buenard',
		'Cabin'                    => 'Cabin',
		'Cabin+Condensed'          => 'Cabin Condensed',
		'Caesar+Dressing'          => 'Caesar Dressing',
		'Cagliostro'               => 'Cagliostro',
		'Cambo'                    => 'Cambo',
		'Candal'                   => 'Candal',
		'Cantarell'                => 'Cantarell',
		'Cardo'                    => 'Cardo',
		'Carme'                    => 'Carme',
		'Carter+One'               => 'Carter One',
		'Ceviche+One'              => 'Ceviche One',
		'Changa+One'               => 'Changa One',
		'Chango'                   => 'Chango',
		'Chelsea+Market'           => 'Chelsea Market',
		'Cherry+Cream+Soda'        => 'Cherry Cream Soda',
		'Chewy'                    => 'Chewy',
		'Chicle'                   => 'Chicle',
		'Coda'                     => 'Coda',
		'Coda+Caption'             => 'Coda Caption',
		'Comfortaa'                => 'Comfortaa',
		'Concert+One'              => 'Concert One',
		'Condiment'                => 'Condiment',
		'Contrail+One'             => 'Contrail One',
		'Convergence'              => 'Convergence',
		'Cookie'                   => 'Cookie',
		'Copse'                    => 'Copse',
		'Corben'                   => 'Corben',
		'Cousine'                  => 'Cousine',
		'Coustard'                 => 'Coustard',
		'Covered+By+Your+Grace'    => 'Covered By Your Grace',
		'Crete+Round'              => 'Crete Round',
		'Crimson+Text'             => 'Crimson Text',
		'Crushed'                  => 'Crushed',
		'Cuprum'                   => 'Cuprum',
		'Damion'                   => 'Damion',
		'Dancing+Script'           => 'Dancing Script',
		'Days+One'                 => 'Days One',
		'Delius'                   => 'Delius',
		'Delius+Unicase'           => 'Delius Unicase',
		'Devonshire'               => 'Devonshire',
		'Didact+Gothic'            => 'Didact Gothic',
		'Dorsa'                    => 'Dorsa',
		'Dr+Sugiyama'              => 'Dr Sugiyama',
		'Droid+Sans'               => 'Droid Sans',
		'Droid+Sans+Mono'          => 'Droid Sans Mono',
		'Droid+Serif'              => 'Droid Serif',
		'Duru+Sans'                => 'Duru Sans',
		'Dynalight'                => 'Dynalight',
		'Eater'                    => 'Eater',
		'EB+Garamond'              => 'EB Garamond',
		'Electrolize'              => 'Electrolize',
		'Emblema+One'              => 'Emblema One',
		'Engagement'               => 'Engagement',
		'Enriqueta'                => 'Enriqueta',
		'Erica+One'                => 'Erica One',
		'Esteban'                  => 'Esteban',
		'Euphoria+Script'          => 'Euphoria Script',
		'Exo'                      => 'Exo',
		'Expletus+Sans'            => 'Expletus Sans',
		'Fanwood+Text'             => 'Fanwood Text',
        'Fauna+One'                => 'Fauna One',
		'Federant'                 => 'Federant',
		'Federo'                   => 'Federo',
		'Felipa'                   => 'Felipa',
        'Fjalla One'                   => 'Fjalla One',
		'Fjord+One'                => 'Fjord One',
		'Flamenco'                 => 'Flamenco',
		'Flavors'                  => 'Flavors',
		'Fondamento'               => 'Fondamento',
		'Fontdiner+Swanky'         => 'Fontdiner Swanky',
		'Forum'                    => 'Forum',
		'Francois+One'             => 'Francois One',
		'Fresca'                   => 'Fresca',
		'Fugaz+One'                => 'Fugaz One',
		'Gentium+Basic'            => 'Gentium Basic',
		'Gentium+Book+Basic'       => 'Gentium Book Basic',
		'Geo'                      => 'Geo',
		'Germania+One'             => 'Germania One',
        'Gilda Display'            => 'Gilda Display',
		'Give+You+Glory'           => 'Give You Glory',
		'Glegoo'                   => 'Glegoo',
		'Gloria+Hallelujah'        => 'Gloria Hallelujah',
		'Goblin+One'               => 'Goblin One',
		'Gochi+Hand'               => 'Gochi Hand',
		'Goudy+Bookletter+1911'    => 'Goudy Bookletter 1911',
		'Gravitas+One'             => 'Gravitas One',
		'Gruppo'                   => 'Gruppo',
		'Gudea'                    => 'Gudea',
		'Habibi'                   => 'Habibi',
		'Hammersmith+One'          => 'Hammersmith One',
		'Handlee'                  => 'Handlee',
		'Holtwood+One+SC'          => 'Holtwood One SC',
		'Homenaje'                 => 'Homenaje',
		'Iceberg'                  => 'Iceberg',
		'Iceland'                  => 'Iceland',
		'IM+Fell+Double+Pica'      => 'IM Fell Double Pica',
		'IM+Fell+Double+Pica+SC'   => 'IM Fell Double Pica SC',
		'IM+Fell+DW+Pica+SC'       => 'IM Fell DW Pica SC',
		'IM+Fell+French+Canon'     => 'IM Fell French Canon',
		'IM+Fell+French+Canon+SC'  => 'IM Fell French Canon SC',
		'IM+Fell+Great+Primer'     => 'IM Fell Great Primer',
		'IM+Fell+Great+Primer+SC'  => 'IM Fell Great Primer SC',
		'Inconsolata'              => 'Inconsolata',
		'Inder'                    => 'Inder',
		'Indie+Flower'             => 'Indie Flower',
		'Irish+Grover'             => 'Irish Grover',
		'Italianno'                => 'Italianno',
		'Jim+Nightshade'           => 'Jim Nightshade',
		'Jockey+One'               => 'Jockey One',
		'Josefin+Sans'             => 'Josefin Sans',
		'Josefin+Slab'             => 'Josefin Slab',
		'Judson'                   => 'Judson',
		'Julee'                    => 'Julee',
		'Junge'                    => 'Junge',
		'Jura'                     => 'Jura',
		'Just+Another+Hand'        => 'Just Another Hand',
		'Kameron'                  => 'Kameron',
		'Kaushan+Script'           => 'Kaushan Script',
		'Kelly+Slab'               => 'Kelly Slab',
		'Kenia'                    => 'Kenia',
        'Kite One'                    => 'Kite One',
		'Knewave'                  => 'Knewave',
		'Kotta+One'                => 'Kotta One',
		'Kreon'                    => 'Kreon',
		'Lancelot'                 => 'Lancelot',
		'Lato'                     => 'Lato',
		'Lekton'                   => 'Lekton',
		'Lemon'                    => 'Lemon',
		'Lilita+One'               => 'Lilita One',
		'Limelight'                => 'Limelight',
		'Linden+Hill'              => 'Linden Hill',
		'Lobster'                  => 'Lobster',
		'Lobster+Two'              => 'Lobster Two',
		'Lora'                     => 'Lora',
		'Love+Ya+Like+A+Sister'    => 'Love Ya Like A Sister',
		'Luckiest+Guy'             => 'Luckiest Guy',
		'Lustria'                  => 'Lustria',
		'Macondo'                  => 'Macondo',
		'Macondo+Swash+Caps'       => 'Macondo Swash Caps',
		'Magra'                    => 'Magra',
		'Maiden+Orange'            => 'Maiden Orange',
		'Mako'                     => 'Mako',
		'Marck+Script'             => 'Marck Script',
		'Marko+One'                => 'Marko One',
		'Marmelad'                 => 'Marmelad',
		'Marvel'                   => 'Marvel',
		'Mate'                     => 'Mate',
		'Mate+SC'                  => 'Mate SC',
		'Maven+Pro'                => 'Maven Pro',
		'MedievalSharp'            => 'MedievalSharp',
		'Medula+One'               => 'Medula One',
		'Megrim'                   => 'Megrim',
		'Merienda+One'             => 'Merienda One',
		'Merriweather'             => 'Merriweather',
        'Merriweather+Sans'        => 'Merriweather Sans',
		'Metamorphous'             => 'Metamorphous',
		'Metrophobic'              => 'Metrophobic',
		'Michroma'                 => 'Michroma',
		'Miltonian+Tattoo'         => 'Miltonian Tattoo',
		'Modern+Antiqua'           => 'Modern Antiqua',
		'Molengo'                  => 'Molengo',
		'Monoton'                  => 'Monoton',
		'Montaga'                  => 'Montaga',
		'Montez'                   => 'Montez',
		'Mountains+of+Christmas'   => 'Mountains of Christmas',
		'Mr+Bedfort'               => 'Mr Bedfort',
		'Mr+Dafoe'                 => 'Mr Dafoe',
		'Mrs+Sheppards'            => 'Mrs Sheppards',
		'Muli'                     => 'Muli',
		'Neucha'                   => 'Neucha',
		'Neuton'                   => 'Neuton',
		'News+Cycle'               => 'News Cycle',
		'Niconne'                  => 'Niconne',
		'Nixie+One'                => 'Nixie One',
		'Nobile'                   => 'Nobile',
		'Norican'                  => 'Norican',
		'Nosifer'                  => 'Nosifer',
		'Nothing+You+Could+Do'     => 'Nothing You Could Do',
		'Noticia+Text'             => 'Noticia Text',
		'Nova+Cut'                 => 'Nova Cut',
		'Nova+Flat'                => 'Nova Flat',
		'Nova+Mono'                => 'Nova Mono',
		'Nova+Oval'                => 'Nova Oval',
		'Nova+Round'               => 'Nova Round',
		'Nova+Script'              => 'Nova Script',
		'Nova+Slim'                => 'Nova Slim',
		'Nova+Square'              => 'Nova Square',
		'Numans'                   => 'Numans',
		'Nunito'                   => 'Nunito',
		'Old+Standard+TT'          => 'Old Standard TT',
		'Oldenburg'                => 'Oldenburg',
		'Open+Sans'                => 'Open Sans',
		'Open+Sans+Condensed'      => 'Open Sans Condensed',
		'Orbitron'                 => 'Orbitron',
		'Original+Surfer'          => 'Original Surfer',
		'Oswald'                   => 'Oswald',
		'Overlock'                 => 'Overlock',
		'Overlock+SC'              => 'Overlock SC',
		'Ovo'                      => 'Ovo',
        'Oxygen'                   => 'Oxygen',
		'Pacifico'                 => 'Pacifico',
		'Parisienne'               => 'Parisienne',
		'Passero+One'              => 'Passero One',
		'Passion+One'              => 'Passion One',
		'Patrick+Hand'             => 'Patrick Hand',
		'Patua+One'                => 'Patua One',
        'Pathway+Gothic+One'       => 'Pathway Gothic One',
		'Paytone+One'              => 'Paytone One',
		'Permanent+Marker'         => 'Permanent Marker',
		'Petrona'                  => 'Petrona',
		'Philosopher'              => 'Philosopher',
		'Piedra'                   => 'Piedra',
		'Pinyon+Script'            => 'Pinyon Script',
		'Play'                     => 'Play',
		'Playball'                 => 'Playball',
		'Playfair+Display'         => 'Playfair Display',
		'Podkova'                  => 'Podkova',
		'Poller+One'               => 'Poller One',
		'Pompiere'                 => 'Pompiere',
		'Prata'                    => 'Prata',
		'Prociono'                 => 'Prociono',
		'PT+Sans'                  => 'PT Sans',
		'PT+Sans+Caption'          => 'PT Sans Caption',
		'PT+Sans+Narrow'           => 'PT Sans Narrow',
		'PT+Serif'                 => 'PT Serif',
		'PT+Serif+Caption'         => 'PT Serif Caption',
		'Quantico'                 => 'Quantico',
		'Quattrocento'             => 'Quattrocento',
		'Quattrocento+Sans'        => 'Quattrocento Sans',
		'Questrial'                => 'Questrial',
		'Quicksand'                => 'Quicksand',
		'Qwigley'                  => 'Qwigley',
		'Radley'                   => 'Radley',
		'Raleway'                  => 'Raleway',
        'Rambla'                   => 'Rambla',
		'Rammetto+One'             => 'Rammetto One',
		'Rancho'                   => 'Rancho',
		'Rationale'                => 'Rationale',
		'Redressed'                => 'Redressed',
		'Reenie+Beanie'            => 'Reenie Beanie',
		'Ribeye'                   => 'Ribeye',
		'Ribeye+Marrow'            => 'Ribeye Marrow',
		'Righteous'                => 'Righteous',
        'Roboto'                   => 'Roboto',
        'Roboto+Condensed'         => 'Roboto Condensed',
		'Rochester'                => 'Rochester',
		'Rock+Salt'                => 'Rock Salt',
		'Rokkitt'                  => 'Rokkitt',
		'Ropa+Sans'                => 'Ropa Sans',
		'Rosario'                  => 'Rosario',
		'Ruda'                     => 'Ruda',
        'Rufina'                   => 'Rufina',
		'Ruluko'                   => 'Ruluko',
		'Ruslan+Display'           => 'Ruslan Display',
		'Sail'                     => 'Sail',
		'Salsa'                    => 'Salsa',
		'Sancreek'                 => 'Sancreek',
        'Sanchez'                  => 'Sanchez',
		'Sansita+One'              => 'Sansita One',
		'Satisfy'                  => 'Satisfy',
		'Shadows+Into+Light'       => 'Shadows Into Light',
		'Shanti'                   => 'Shanti',
		'Share'                    => 'Share',
		'Sigmar+One'               => 'Sigmar One',
		'Signika'                  => 'Signika',
		'Signika+Negative'         => 'Signika Negative',
        'Sintony'                 => 'Sintony',
		'Six+Caps'                 => 'Six Caps',
		'Slackey'                  => 'Slackey',
		'Smokum'                   => 'Smokum',
		'Smythe'                   => 'Smythe',
		'Sofia'                    => 'Sofia',
		'Sonsie+One'               => 'Sonsie One',
		'Sorts+Mill+Goudy'         => 'Sorts Mill Goudy',
		'Special+Elite'            => 'Special Elite',
		'Spicy+Rice'               => 'Spicy Rice',
		'Spinnaker'                => 'Spinnaker',
		'Spirax'                   => 'Spirax',
		'Squada+One'               => 'Squada One',
		'Stardos+Stencil'          => 'Stardos Stencil',
		'Stint+Ultra+Condensed'    => 'Stint Ultra Condensed',
        'Strait'                   => 'Strait',
		'Stoke'                    => 'Stoke',
		'Sue+Ellen+Francisco'      => 'Sue Ellen Francisco',
		'Supermercado+One'         => 'Supermercado One',
		'Syncopate'                => 'Syncopate',
        'Tauri'                    => 'Tauri',
		'Tangerine'                => 'Tangerine',
        'Telex'                    => 'Telex',
		'Tenor+Sans'               => 'Tenor Sans',
		'Terminal+Dosis'           => 'Terminal Dosis',
		'Tienne'                   => 'Tienne',
		'Tinos'                    => 'Tinos',
		'Titan+One'                => 'Titan One',
        'Titillium Web'            => 'Titillium Web',
		'Trade+Winds'              => 'Trade Winds',
		'Trochut'                  => 'Trochut',
		'Trykker'                  => 'Trykker',
		'Tulpen+One'               => 'Tulpen One',
		'Ubuntu'                   => 'Ubuntu',
		'Ubuntu+Condensed'         => 'Ubuntu Condensed',
		'Ubuntu+Mono'              => 'Ubuntu Mono',
		'Ultra'                    => 'Ultra',
		'Uncial+Antiqua'           => 'Uncial Antiqua',
		'UnifrakturCook'           => 'UnifrakturCook',
		'UnifrakturMaguntia'       => 'UnifrakturMaguntia',
		'Unkempt'                  => 'Unkempt',
		'Unlock'                   => 'Unlock',
		'Varela'                   => 'Varela',
		'Varela+Round'             => 'Varela Round',
		'Vibur'                    => 'Vibur',
		'Vidaloka'                 => 'Vidaloka',
		'Viga'                     => 'Viga',
		'Volkhov'                  => 'Volkhov',
		'Vollkorn'                 => 'Vollkorn',
		'Voltaire'                 => 'Voltaire',
		'VT323'                    => 'VT323',
		'Waiting+for+the+Sunrise'  => 'Waiting for the Sunrise',
		'Wallpoet'                 => 'Wallpoet',
		'Walter+Turncoat'          => 'Walter Turncoat',
		'Wellfleet'                => 'Wellfleet',
		'Wire+One'                 => 'Wire One',
		'Yanone+Kaffeesatz'        => 'Yanone Kaffeesatz',
		'Yellowtail'               => 'Yellowtail',
		'Yeseva+One'               => 'Yeseva One',
		'Yesteryear'               => 'Yesteryear',
		);

       return $fonts;
}


// Function to Get Store Details
function getStoreDetails($storeid,$key)
{
    $gedetails = Settings::where('key',$key)->where('store_id',$storeid)->first();
    $new = isset($gedetails->value) ? $gedetails->value : '';
    return $new;
}

function getLoyaltyDetails($storeid,$key){
     
    $gedetails = Settings::where('store_id',$storeid)->where('key',$key)->first();
    
        $point = Settings::select('value')->where('store_id',$storeid)->where('key','point')->first();
        $unserializepoint =unserialize(isset($point['value']) ? $point['value'] :'');
       
        $money = Settings::select('value')->where('store_id',$storeid)->where('key','money')->first();
        $unserializemoney =unserialize(isset($money['value']) ? $money['value'] :'');
       
   
    
    $value = isset($gedetails->value) ? $gedetails->value : '';
    $data['value'] = $value;
    $data['unserializepoint'] =$unserializepoint;
    $data['unserializemoney'] =$unserializemoney;


    return $data;
}

function currentStoreId()
{
    if(session()->has('store_id'))
    {
        $storeID = session()->get('store_id');
    }
    else
    {
        $storeID = 0;
    }
    return $storeID;
}


// Check Ban IP
function checkBanIp($ip)
{
    $ip = CustomerBanIp::select('ip')->where('ip',$ip)->first();
    return $ip;
}


// Check New Model
function checkNewModel()
{
    $setting = Settings::where('key','new_module_status')->first();
    if($setting != '' || !empty($setting))
    {
        return 1;
    }
    else
    {
        return 0;
    }
}



function getStores()
{
    $stores = Store::get();
    return $stores;
}


function getCurrentStoreURL($id)
{
    $store = Store::select('ssl')->where('store_id',$id)->first();
    $url = isset($store->ssl) ? $store->ssl : '';
    return $url;
}


function get_sub_opt_names($sub_opt_ids)
{
    $arr = array();
    $ids = explode(',',$sub_opt_ids);

    foreach($ids as $id)
    {
        $getname = Topping::select('name_topping')->where('id_topping',$id)->first();
        $name = isset($getname->name_topping) ? $getname->name_topping : '';
        $arr[] = $name;
    }

    $names = implode(',',$arr);
    return $names;
}



function getZonebyId($zid)
{
    $zone = Region::where('zone_id',$zid)->first();
    return $zone;
}


// Function of Genrate Token
function genratetoken($length = 32) {
    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $max = strlen($string) - 1;

    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $token .= $string[mt_rand(0, $max)];
    }

    return $token;
}



// Function of Sidebar Menu
function sidebar()
{
    $all_menu = MainMenu::orderBy('menu_order','ASC')->get();
    return $all_menu;
}




// Function of Sidebar Menu of Submenu
function submenu($menu_id)
{
    $sub_menu = Submenu::where('menu_id',$menu_id)->get();
    return $sub_menu;
}




function submenuofsubmenu($submenu_id)
{
    $submenu_of_submenu = Submenu::where('parent_id',$submenu_id)->get();
    return $submenu_of_submenu;
}




// Function of Submenu Actions
function submenuaction($smenu_id)
{
    $sub_menu = Submenu::where('parent_id',$smenu_id)->get();
    return $sub_menu;
}




// Function of Get User Role Action
function get_rel_userrole_action($where)
{
    $user_role_action = Permission::where($where)->first();
    return $user_role_action;
}




// Function of Fetch Other Users Sidebar Menu
function fetch_otherusers_mainmenu($where)
{
    $resultset = MainMenu::where($where)->select('oc_main_menu.*')->join('oc_userrole_actions','oc_userrole_actions.menu_id','=','oc_main_menu.id')->orderBy('oc_main_menu.menu_order')->get();
    return $resultset;
}




// Function of Fetch Other Users Sidebar Menu of Submenu
function fetch_otherusers_mainmenu_submenu($where)
{
    $resultset = Permission::where($where)->where('oc_menu_actions.is_hidden','!=',4)->select('oc_menu_actions.*')->join('oc_menu_actions','oc_menu_actions.id','=','oc_userrole_actions.action_id')->orderBy('oc_menu_actions.id')->get();
    return $resultset;
}


function getProductSize($sizeid,$productid)
{
    $size = ToppingProductPriceSize::where('id_size',$sizeid)->where('id_product',$productid)->first();
    return $size;
}


// Function of Check Userrole of Submenus
function check_user_role($action_id)
{
    $admin = user_details();
    $uaccess = $admin->user_group_id;

    if($uaccess != 1)
    {
        $result = Permission::where('subaction_id','=',$action_id)->where('role_id','=',$uaccess)->get();

        if(count($result) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 1;
    }

}




// Function of Check Userrole for Single Menu
function check_user_role_for_single_menu($action_id)
{
    $admin = user_details();
    $uaccess = $admin->user_group_id;

    if($uaccess != 1)
    {
        $result = Permission::where('action_id','=',$action_id)->where('role_id','=',$uaccess)->get();

        if(count($result) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    else
    {
        return 1;
    }

}

function getmaincat()
{
    $fetchparent = CategoryDetail::where('oc_category.parent_id', '=', 0)->select('oc_category.*', 'ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();

    foreach ($fetchparent as $main) {
        $subcat = CategoryDetail::where('oc_category.parent_id',$main->category_id)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();
    }

    return $fetchparent;
}



//Function of Get Sub Category
function get_subcat($parentid)
{
    $subcat = CategoryDetail::where('oc_category.parent_id',$parentid)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();
    return $subcat;
}




// Function of Subcategory of Category
function depend_subcat($value1)
{
    $subcat1 = CategoryDetail::where('oc_category.parent_id',$value1)->select('oc_category.*','ocd.name as cat_name')->leftJoin('oc_category_description as ocd', 'ocd.category_id', '=', 'oc_category.category_id')->get();;
    return $subcat1;
}




//
function fetch_mainmenu_submenucolumn($id)
{
    $subMenu = SubMenu::where('menu_id',$id)->where('oc_menu_actions.is_hidden','!=',4)->select('slugurl')->get()->toArray();

    $arr = array_map(function ($value) {
        return $value['slugurl'];
    }, $subMenu);

    return $arr;

}


?>
