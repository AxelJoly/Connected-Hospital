<?php

/**
 * Created by PhpStorm.
 * User: axel
 * Date: 15/02/2018
 * Time: 14:10
 */
namespace AppBundle\Services;
use AppBundle\Services\ChartData;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;

class Chart
{
    const ANIMATION_STARTUP = true;
    const ANIMATION_DURATION = 1000;

    private $chartData;


    public function __construct(ChartData $chartData){
        $this->chartData = $chartData;
    }

    public function chartBuilder($id){
        $pieChart = new LineChart();
        $temp = $this->chartData->getData($id);

        if($temp == null){
            return null;

        }else {
            $pieChart->getData()->setArrayToDataTable(
                [['Data', "BPM", "Glycemia", "Temperature", "BloodPressure"],
                    $temp[0],
                    $temp[1],
                    $temp[2],
                    $temp[3],
                    $temp[4],
                ]
            );

            $pieChart->getOptions()->getAnimation()->setStartup(true);
            $pieChart->getOptions()->getAnimation()->setDuration(500);
            $pieChart->getOptions()->setTitle("Patient's data");
            $pieChart->getOptions()->setHeight(500);
            $pieChart->getOptions()->setWidth(900);
            $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
            $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
            $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
            $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
            $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

            return $pieChart;
        }
    }
}