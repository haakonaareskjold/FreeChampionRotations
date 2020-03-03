<?php

namespace App\Classes;

use GuzzleHttp\Client;

class Guzzleclass
{
    private $id;
    private $content;
    private const IMG = "https://ddragon.leagueoflegends.com/cdn/10.4.1/img/champion/"; // patch 10.4.1
    private const CHAMPIONS = "http://ddragon.leagueoflegends.com/cdn/10.4.1/data/en_US/champion.json"; // patch 10.4.1
    private const KEY = "SUBMIT_KEY_HERE"; // API KEY

    public function fetchID()
    {
        if (self::KEY == "SUBMIT_KEY_HERE") {
            die('Please replace the const KEY with an actual key in Guzzleclass.php');
        }
        if (isset($_POST['EUW'])) {
            // V3 champion rotation API
            $riotapi = new Client();
            $response = $riotapi->request(
                'GET',
                'https://euw1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . self::KEY
            );
        } elseif (isset($_POST['NA'])) {
            $riotapi = new Client();
            $response = $riotapi->request(
                'GET',
                'https://na1.api.riotgames.com/lol/platform/v3/champion-rotations?api_key=' . self::KEY
            );
        }

        // Champion V3 REST API
        $guzzle_json =  $response->getBody();
        $guzzle_array = json_decode($guzzle_json, true);
        $this->id = $guzzle_array['freeChampionIds'];

        // ddragon JSON
        $ddragon = new Client();
        $res = $ddragon->get(self::CHAMPIONS);
        $ddragon_json = $res->getBody();
        $this->content = json_decode($ddragon_json, true);
    }

    public function guzzleResults()
    {
        foreach ($this->content['data'] as $champ) {
            foreach ($this->id as $freeid) {
                if ($champ["key"] == $freeid) {
                    $displayImg = self::IMG . $champ["id"] . ".png";
?> <div class="item">
                        <?php
                        echo '<img src="' . $displayImg . '">';
                        ?>
                        <span class="caption"><?php echo $champ['id']; ?></span>
                    </div>
<?php
                }
            }
        }
    }

    public function serverCheck()
    {
        if (isset($_POST['EUW'])) {
            echo 'EUW';
        } elseif (isset($_POST['NA'])) {
            echo 'NA';
        }
    }
}
