<?php

use Stimulsoft\Report\StiReport;
use Stimulsoft\Viewer\StiViewer;
use Stimulsoft\StiHandler;
use Stimulsoft\Enums\StiComponentType;
use Stimulsoft\StiJavaScript;
use Stimulsoft\Viewer\Enums\StiToolbarDisplayMode;
use Stimulsoft\Viewer\Enums\StiWebViewMode;
use Stimulsoft\Viewer\StiViewerOptions;
?>
<!DOCTYPE html>

<html>

<head>

    <title>Receipt Voucher</title>

    <?php
    $js = new StiJavaScript(StiComponentType::Viewer);
    $js->renderHtml();
    $handler = new StiHandler('/report-handler');
    $handler->renderHtml();
    ?>


    <script type="text/javascript">
        var income_note_id = <?php echo json_encode($income_note_id); ?>;

        function onBeforeRender(args) {
            var report = args.report;
            report.dictionary.variables.getByName("income_note_id").valueObject = income_note_id;
        }
    </script>

    <?php
    $report = new StiReport();
    $report->loadFile("/get-income-note-data-report");
    $report->onBeforeRender = 'onBeforeRender';

    $options = new StiViewerOptions();
    $options->toolbar->viewMode = StiWebViewMode::MultiplePages;
    $options->appearance->fullScreenMode = false;
    $options->toolbar->displayMode = StiToolbarDisplayMode::Simple;
    $options->toolbar->showZoomButton = false;
    $options->toolbar->showDesignButton = false;
    $options->toolbar->showViewModeButton = false;
    $options->toolbar->showEditorButton = false;
    $options->toolbar->showFullScreenButton = false;
    $options->toolbar->showBookmarksButton = false;
    $options->toolbar->showLastPageButton = false;
    $options->toolbar->showNextPageButton = false;
    $options->toolbar->showCurrentPageControl = false;
    $options->toolbar->showButtonCaptions = false;
    $options->toolbar->showOpenButton = false;
    $options->toolbar->showSaveButton = false;
    $options->toolbar->showSendEmailButton = false;
    $options->toolbar->showFindButton = false;
    $options->toolbar->showParametersButton = false;
    $options->toolbar->showResourcesButton = false;
    $options->toolbar->showRefreshButton = false;
    $options->toolbar->showPreviousPageButton = false;
    $options->toolbar->showFirstPageButton = false;
    $options->toolbar->showAboutButton = false;

    $viewer = new StiViewer('viewer', $options);
    $viewer->onBeginProcessData = true;
    $viewer->process();
    $viewer->report = $report;
    $viewer->renderHtml("viewerContent");
    ?>
    <style>
        html,
        body {
            font-family: sans-serif;
        }

        .stiJsViewerForm {
            display: none;
        }

        .stiJsViewerDisabledPanel {
            z-index: 0;
            display: none;
        }

        .stiJsViewerMainPanel div div table {
            border: none;
        }

        .stiJsViewerStandartSmallButtonDefault table tbody tr td table tbody tr td div table tbody tr td {
            display: block;
        }

        .StiPageContainer div div img[src ^="data:image/png;base64,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"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }

        .stiJsViewerMenu .stiJsViewerMenuStandartItem {
            display: none;
        }

        .stiJsViewerMenu div:not(.stiJsViewerMenuDisabledItem):nth-child(3n) {
            display: flex;
        }

        #viewerToolTip {
            display: none;
        }

        div.stiJsViewerPage {
            outline: none !important;
        }

        #viewerReportPanel,
        .stiJsViewerToolBar,
        .stiJsViewerToolBarTable {
            background: #fafafa !important;
        }

        div.StiPageContainer>*:last-child {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }

        @media print {
            div.StiPageContainer>*:last-child {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }

            .StiPageContainer div div img[src ^="data:image/png;base64,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"] {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }

        /* width */
        ::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #e8e8e8;
            border-radius: 5px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #c3c3c3;
        }
    </style>
</head>

<body>
    <div id="viewerContent"></div>
</body>

</html>