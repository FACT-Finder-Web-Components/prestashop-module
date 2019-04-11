<?php

namespace Omikron\Factfinder\Prestashop\Export\Catalog\Fields;

use Omikron\Factfinder\Prestashop\Export\Filter\ExtendedTextFilter as TextFilter;

class Attributes implements ProductFieldInterface
{
    /** @var TextFilter */
    private $filter;

    /** @var */
    private $languageId;

    public function __construct()
    {
        $this->languageId = \ContextCore::getContext()->language->id;
        $this->filter     = new TextFilter();
    }

    public function getValue($productId)
    {
        $features = array_reduce($this->getFeaturesToExport($productId), function (array $res, array $feature) {
            $featureName   = \FeatureCore::getFeature($this->languageId, $feature['id_feature']);
            $searchedValue = $feature['id_feature_value'];

            $featureValue = array_filter(\FeatureValueCore::getFeatureValuesWithLang($this->languageId, $feature['id_feature']),
                function ($value) use ($searchedValue) {
                    return $searchedValue == $value['id_feature_value'];
                }
            );

            $res[] = $this->formatAttribute($featureName['name'], reset($featureValue)['value']);
            return $res;
        }, []);

        return $features ? '|' . implode('|', $features) . '|' : '';
    }

    /**
     * @param $productId
     *
     * @return array
     */
    private function getFeaturesToExport($productId)
    {
        $featuresToExport = explode(',', (string) \ConfigurationCore::get('FF_ADDITIONAL_ATTRIBUTES'));
        return array_filter(\ProductCore::getFeaturesStatic($productId), function ($feature) use ($featuresToExport) {
            return in_array($feature['id_feature'], $featuresToExport);
        });
    }

    private function formatAttribute($featureName, $featureValue)
    {
        return "{$this->filter->filterValue($featureName)}={$this->filter->filterValue($featureValue)}";
    }
}
