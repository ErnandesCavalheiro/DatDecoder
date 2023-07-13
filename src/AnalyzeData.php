<?php

class AnalyzeData
{
    public static function findHighestTotalSale($data)
    {
        $highestTotal = 0;
        $highestSale = null;

        foreach ($data['sale'] as $saleList) {
            foreach ($saleList as $sale) {
                $total = $sale['itemList']['total'];

                if ($total > $highestTotal) {
                    $highestTotal = $total;
                    $highestSale = $sale;
                }
            }
        }

        return $highestSale;
    }

    public static function countClients($data)
    {
        $total = self::count($data['client']);

        return $total;
    }

    public static function countSellers($data)
    {
        $total = self::count($data['seller']);

        return $total;
    }

    public static function worstSeller($data)
    {
        $totals = [];

        // Calcular o total de vendas para cada vendedor
        foreach ($data['sale'] as $saleList) {
            foreach ($saleList as $sale) {
                $sellerName = $sale['sellerName'];
                $total = $sale['itemList']['total'];

                if (isset($totals[$sellerName])) {
                    $totals[$sellerName] += $total;
                } else {
                    $totals[$sellerName] = $total;
                }
            }
        }

        // Encontrar o vendedor com o menor total de vendas
        $lowestSeller = null;
        $lowestTotal = null;

        foreach ($totals as $seller => $total) {
            if ($lowestTotal === null || $total < $lowestTotal) {
                $lowestSeller = $seller;
                $lowestTotal = $total;
            }
        }

        return $lowestSeller;
    }

    public static function count($dataList)
    {
        $total = 0;

        foreach ($dataList as $data) {
            $total += count($data);
        }

        return $total;
    }
}
