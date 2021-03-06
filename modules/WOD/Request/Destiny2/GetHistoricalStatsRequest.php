<?php

namespace Apine\Modules\WOD\Request\Destiny2;

use Apine\Modules\BungieNetPlatform\Destiny2\DestinyActivityModeType;
use Apine\Modules\BungieNetPlatform\Destiny2\GetHistoricalStatsResponse;
use JsonMapper;

class GetHistoricalStatsRequest extends BungieNetPlatformRequest {

    /**
     * @var int
     */
    private $membershipType;

    /**
     * @var string
     */
    private $membershipId;

    /**
     * @var string
     */
    private $characterId;

    public function __construct($membershipType, $membershipId, $characterId) {
        $this->membershipType = $membershipType;
        $this->membershipId = $membershipId;
        $this->characterId = $characterId;
        $this->cacheTime = 14400; // 4 hours
    }

    /**
     * @return GetHistoricalStatsResponse
     */
    public function getResponse() {
        list($this->code, $body) = parent::makeRequest("%s/Account/%s/Character/%s/Stats", "GET", "Destiny2", [
            $this->membershipType,
            $this->membershipId,
            $this->characterId
        ], [
            "modes" => DestinyActivityModeType::AllPvP.",".DestinyActivityModeType::AllPvE
        ]);

        $json = json_decode($body);
        $mapper = new JsonMapper();
        $object = $mapper->map($json, new GetHistoricalStatsResponse());
        /** @var GetHistoricalStatsResponse $object */
        return $object;
    }

}