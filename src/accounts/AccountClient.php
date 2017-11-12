<?php

namespace iamgold\facebook\ads\accounts;

use Exception;
use iamgold\facebook\ads\AbstractClient;
use iamgold\facebook\ads\handlers\{AdsCampaignHandler, AdsAdSetsHandler, AdsAdsHandler, ParamsHandler};

/**
 * This class is provide serveral method to access Facebook Ads
 * Account.
 *
 * @author Eric Huang <iamgold0105@gmail.com>
 * @version 1.0.0
 */
class AccountClient extends AbstractClient implements InterfaceAccountClient
{
    /**
     * Find by specific account
     *
     * @param string $accountId
     * @return iamgold\facebook\ads\Result
     */
    public function find($accountId = null)
    {
        if (empty($accountId))
            throw new Exception("Undefined \$accountId", 404);

        $command = $this->createHandlerList()->resolve();

        return $command->exec([
                'accountId' =>  $accountId,
                'credential' => $this->getCredential()
            ]);
    }

    /**
     * Find campaigns by specific account id
     *
     * @param string $accountId
     * @param array $params
     * @return iamgold\facebook\ads\Result
     */
    public function findCampaigns($accountId = null, arrays $params = [])
    {
        if (empty($accountId))
            throw new Exception("Undefined \$accountId", 404);

        $command = $this->createHandlerList()->addPathHandler(new AdsCampaignHandler)
                                             ->add(new ParamsHandler)
                                             ->resolve();

        return $command->exec([
                'accountId' => $accountId,
                'params' => &$params,
                'credential' => $this->getCredential()
            ]);
    }

    /**
     * Find adsets by specific account id
     *
     * @param string $accountId
     * @param array $params
     * @return iamgold\facebook\ads\Result
     */
    public function findAdSets($accountId = null, arrays $params = [])
    {
        if (empty($accountId))
            throw new Exception("Undefined \$accountId", 404);

        $command = $this->createHandlerList()->addPathHandler(new AdsAdSetsHandler)
                                             ->add(new ParamsHandler)
                                             ->resolve();

        return $command->exec([
                'accountId' => $accountId,
                'params' => &$params,
                'credential' => $this->getCredential()
            ]);
    }

    /**
     * Find ads by specific account id
     *
     * @param string $accountId
     * @param array $params
     * @return iamgold\facebook\ads\Result
     */
    public function findAds($accountId = null, arrays $params = [])
    {
        if (empty($accountId))
            throw new Exception("Undefined \$accountId", 404);

        $command = $this->createHandlerList()->addPathHandler(new AdsAdsHandler)
                                             ->add(new ParamsHandler)
                                             ->resolve();

        return $command->exec([
                'accountId' => $accountId,
                'params' => &$params,
                'credential' => $this->getCredential()
            ]);
    }

    /**
     * Create an async report
     *
     * @param string $accountId
     * @param array $params
     * @return iamgold\facebook\ads\Result
     */
    public function createAsyncReport($accountId = null, array $params = [])
    {
        if (empty($accountId))
            throw new Exception("Undefined \$accountId", 404);

        $command = $this->createHandlerList()->addPathHandler(new AdsInsightsHandler)
                                             ->add(new ParamsHandler)
                                             ->resolve();

        return $command->exec([
                'accountId' => $accountId,
                'params' => &$params,
                'credential' => $this->getCredential()
            ]);
    }

    /**
     * Create handler list
     *
     * @return iamgold\facebook\ads\HandlerList
     */
    private function createHandlerList()
    {
        return (new HandlerList)->addPathHandler(new AdsAccountHandler);
    }
}
