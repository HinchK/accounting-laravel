<?php

declare(strict_types=1);

namespace Liberu\Accounting\FixedAssets\Actions;

use Liberu\Accounting\FixedAssets\Exceptions\InvalidAsset;
use Liberu\Accounting\FixedAssets\Models\{Asset, AssetCustodian};

final class AssignAssetCustodian
{
    public function handle(Asset $asset, AssetCustodian $custodian): Asset
    {
        if ($asset->team_id !== $custodian->team_id) {
            throw new InvalidAsset('The custodian belongs to a different team.');
        }
        $asset->update(['custodian_id' => $custodian->getKey(), 'custodian_ref' => $custodian->custodian_ref]);

        return $asset->refresh();
    }
}
