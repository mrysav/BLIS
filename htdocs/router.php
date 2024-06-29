<?php

require_once(__DIR__ . "//includes/composer.php");

$request = $_SERVER['REQUEST_URI'];

$log->info("Debug router request $request");

switch ($request) {
    case '/ping':
        require_once(__DIR__ . '/healthcheck.php');
        break;

    case "/lang_update.php":
        require_once(__DIR__ . "/Language/lang_update.php");
        break;

    ## /config folder
    case "/lab_configs.php":
        require_once(__DIR__ . "/config/lab_configs.php");
        break;

    case "/lab_config_home.php":
        require_once(__DIR__ . "/config/lab_config_home.php");
        break;

    case "/grouped_report_config.php":
        require_once(__DIR__ . "/config/grouped_report_config.php");
        break;

    case "/lab_config_new.php":
        require_once(__DIR__ . "/config/lab_config_new.php");
        break;

    case "/lab_config_add.php":
        require_once(__DIR__ . "/config/lab_config_add.php");
        break;

    case "/lab_config_addd.php":
        require_once(__DIR__ . "/config/lab_config_addd.php");
        break;

    case "/lab_config_added.php":
        require_once(__DIR__ . "/config/lab_config_added.php");
        break;

    case "/lab_config_status.php":
        require_once(__DIR__ . "/config/lab_config_status.php");
        break;

    case "/cfield_new.php":
        require_once(__DIR__ . "/config/cfield_new.php");
        break;

    case "/cfield_edit.php":
        require_once(__DIR__ . "/config/cfield_edit.php");
        break;

    case "/worksheet_custom_new.php":
        require_once(__DIR__ . "/config/worksheet_custom_new.php");
        break;

    case "/worksheet_custom_add.php":
        require_once(__DIR__ . "/config/worksheet_custom_add.php");
        break;

    case "/worksheet_custom_added.php":
        require_once(__DIR__ . "/config/worksheet_custom_added.php");
        break;

    case "/worksheet_custom_edit.php":
        require_once(__DIR__ . "/config/worksheet_custom_edit.php");
        break;

    case "/worksheet_custom_update.php":
        require_once(__DIR__ . "/config/worksheet_custom_update.php");
        break;

    case "/worksheet_custom_updated.php":
        require_once(__DIR__ . "/config/worksheet_custom_updated.php");
        break;



    ## /reports folder
    case "/reports.php":
        require_once(__DIR__ . "/reports/reports.php");
        break;

    case "/report_onetesthistory.php":
        require_once(__DIR__ . "/reports/report_onetesthistory.php");
        break;

    case "/report_selected_tests.php":
        require_once(__DIR__ . "/reports/report_selected_tests.php");
        break;

    case "/remove_selected_tests.php":
        require_once(__DIR__ . "/reports/remove_selected_tests.php");
        break;

    case "/retrieve_specimens.php":
        require_once(__DIR__ . "/reports/retrieve_specimens.php");
        break;

    case "/reports_testhistory.php":
        require_once(__DIR__ . "/reports/reports_testhistory.php");
        break;

    case "/viz_test_history.php":
        require_once(__DIR__ . "/reports/viz_test_history.php");
        break;

    case "/reports_user_stats_individual.php":
        require_once(__DIR__ . "/reports/reports_user_stats_individual.php");
        break;

    case "/reports_user_stats_all.php":
        require_once(__DIR__ . "/reports/reports_user_stats_all.php");
        break;

    case "/reports_specimen.php":
        require_once(__DIR__ . "/reports/reports_specimen.php");
        break;

    case "/reports_specimenlog.php":
        require_once(__DIR__ . "/reports/reports_specimenlog.php");
        break;

    case "/reports_print.php":
        require_once(__DIR__ . "/reports/reports_print.php");
        break;

    case "/reports_dailyspecimens.php":
        require_once(__DIR__ . "/reports/reports_dailyspecimens.php");
        break;

    case "/reports_dailypatients.php":
        require_once(__DIR__ . "/reports/reports_dailypatients.php");
        break;

    case "/reports_dailypatientBarcodes.php":
        require_once(__DIR__ . "/reports/reports_dailypatientBarcodes.php");
        break;

    case "/reports_infection.php":
        require_once(__DIR__ . "/reports/reports_infection.php");
        break;

    case "/doctor_stats.php":
        require_once(__DIR__ . "/reports/doctor_stats.php");
        break;

    case "/reports_specimencount.php":
        require_once(__DIR__ . "/reports/reports_specimencount.php");
        break;

    case "/reports_tests_done.php":
        require_once(__DIR__ . "/reports/reports_tests_done.php");
        break;

    case "/reports_test_range_stats.php":
        require_once(__DIR__ . "/reports/reports_test_range_stats.php");
        break;

    case "/reports_testcount_grouped.php":
        require_once(__DIR__ . "/reports/reports_testcount_grouped.php");
        break;

    case "/reports_specimencount_grouped.php":
        require_once(__DIR__ . "/reports/reports_specimencount_grouped.php");
        break;

    case "/reports_tat.php":
        require_once(__DIR__ . "/reports/reports_tat.php");
        break;

    case "/report_disease.php":
        require_once(__DIR__ . "/reports/report_disease.php");
        break;

    case "/infection_aggregate.php":
        require_once(__DIR__ . "/reports/infection_aggregate.php");
        break;

    case "/report_disease_preview.php":
        require_once(__DIR__ . "/reports/report_disease_preview.php");
        break;

    case "/reports_pending.php":
        require_once(__DIR__ . "/reports/reports_pending.php");
        break;

    case "/reports_userlog.php":
        require_once(__DIR__ . "/reports/reports_userlog.php");
        break;

    case "/reports_test.php":
        require_once(__DIR__ . "/reports/reports_test.php");
        break;

    case "/reports_patient.php":
        require_once(__DIR__ . "/reports/reports_patient.php");
        break;

    case "/report_prevalence_agg.php":
        require_once(__DIR__ . "/reports/report_prevalence_agg.php");
        break;

    case "/reports_tat_aggregate.php":
        require_once(__DIR__ . "/reports/reports_tat_aggregate.php");
        break;

    case "/reports_billing.php":
        require_once(__DIR__ . "/reports/reports_billing.php");
        break;

    case "/reports_billing_specific.php":
        require_once(__DIR__ . "/reports/reports_billing_specific.php");
        break;

    case "/specimen_aggregate_report.php":
        require_once(__DIR__ . "/reports/specimen_aggregate_report.php");
        break;

    case "/tests_aggregate_report.php":
        require_once(__DIR__ . "/reports/tests_aggregate_report.php");
        break;

        #-Currently unused php report files-
    case "/reports_session.php":
        require_once(__DIR__ . "/reports/reports_session.php");
        break;

    case "/reports_tat_org.php":
        require_once(__DIR__ . "/reports/reports_tat_org.php");
        break;

    case "/geo_report_dir_prev_cameroon.php":
        require_once(__DIR__ . "/reports/geo_report_dir_prev_cameroon.php");
        break;

    case "/geo_report_dir_tat_cameroon.php":
        require_once(__DIR__ . "/reports/geo_report_dir_tat_cameroon.php");
        break;

    case "/geo_report_dir_prev_ghana.php":
        require_once(__DIR__ . "/reports/geo_report_dir_prev_ghana.php");
        break;

    case "/geo_report_dir_tat_ghana.php":
        require_once(__DIR__ . "/reports/geo_report_dir_tat_ghana.php");
        break;

    case "/geo_report_dir_prev_drc.php":
        require_once(__DIR__ . "/reports/geo_report_dir_prev_drc.php");
        break;

    case "/geo_report_dir_tat_drc.php":
        require_once(__DIR__ . "/reports/geo_report_dir_tat_drc.php");
        break;

    case "/geo_report_dir_prev_uganda.php":
        require_once(__DIR__ . "/reports/geo_report_dir_prev_uganda.php");
        break;

    case "/geo_report_dir_tat_uganda.php":
        require_once(__DIR__ . "/reports/geo_report_dir_tat_uganda.php");
        break;

    case "/geo_report_dir_prev_tanzania.php":
        require_once(__DIR__ . "/reports/geo_report_dir_prev_tanzania.php");
        break;

    case "/geo_report_dir_tat_tanzania.php":
        require_once(__DIR__ . "/reports/geo_report_dir_tat_tanzania.php");
        break;

    case "/geo_report_dir_prev.php":
        require_once(__DIR__ . "/reports/geo_report_dir_prev.php");
        break;

    case "/geo_report_dir_tat.php":
        require_once(__DIR__ . "/reports/geo_report_dir_tat.php");
        break;


    ## /catalog folder
    case "/catalog.php":
        require_once(__DIR__ . "/catalog/catalog.php");
        break;

    case "/specimen_type_new.php":
        require_once(__DIR__ . "/catalog/specimen_type_new.php");
        break;

    case "/specimen_type_add.php":
        require_once(__DIR__ . "/catalog/specimen_type_add.php");
        break;

    case "/specimen_type_added.php":
        require_once(__DIR__ . "/catalog/specimen_type_added.php");
        break;

    case "/specimen_type_edit.php":
        require_once(__DIR__ . "/catalog/specimen_type_edit.php");
        break;

    case "/specimen_type_updated.php":
        require_once(__DIR__ . "/catalog/specimen_type_updated.php");
        break;

    case "/specimen_type_delete.php":
        require_once(__DIR__ . "/catalog/specimen_type_delete.php");
        break;

    case "/test_type_new.php":
        require_once(__DIR__ . "/catalog/test_type_new.php");
        break;

    case "/test_type_add.php":
        require_once(__DIR__ . "/catalog/test_type_add.php");
        break;

    case "/test_type_added.php":
        require_once(__DIR__ . "/catalog/test_type_added.php");
        break;

    case "/test_type_edit.php":
        require_once(__DIR__ . "/catalog/test_type_edit.php");
        break;

    case "/test_type_updated.php":
        require_once(__DIR__ . "/catalog/test_type_updated.php");
        break;

    case "/test_type_delete.php":
        require_once(__DIR__ . "/catalog/test_type_delete.php");
        break;

    case "/country_catalog.php":
        require_once(__DIR__ . "/catalog/country_catalog.php");
        break;

    case "/test_type_edit_agg.php":
        require_once(__DIR__ . "/catalog/test_type_edit_agg.php");
        break;

    case "/test_type_edit_dir.php":
        require_once(__DIR__ . "/catalog/test_type_edit_dir.php");
        break;

    case "/lab_section_edit_dir.php":
        require_once(__DIR__ . "/catalog/lab_section_edit_dir.php");
        break;

    case "/test_type_updated_agg.php":
        require_once(__DIR__ . "/catalog/test_type_updated_agg.php");
        break;



    ## /regn folder
    case "/doctor_register.php":
        require_once(__DIR__ . "/regn/doctor_register.php");
        break;

    case "/doctor_add_patient.php":
        require_once(__DIR__ . "/regn/doctor_add_patient.php");
        break;

    case "/find_patient.php":
        require_once(__DIR__ . "/regn/find_patient.php");
        break;

    case "/new_patient.php":
        require_once(__DIR__ . "/regn/new_patient.php");
        break;

    case "/new_specimen.php":
        require_once(__DIR__ . "/regn/new_specimen.php");
        break;

    case "/specimen_added.php":
        require_once(__DIR__ . "/regn/specimen_added.php");
        break;

    case "/session_print.php":
        require_once(__DIR__ . "/regn/session_print.php");
        break;



    ## /results folder
    case "/results_entry.php":
        require_once(__DIR__ . "/results/results_entry.php");
        break;

    case "/related_tests_results_entry.php":
        require_once(__DIR__ . "/results/related_tests_results_entry.php");
        break;

    case "/results_batch_add.php":
        require_once(__DIR__ . "/results/results_batch_add.php");
        break;

    case "/results_verify.php":
        require_once(__DIR__ . "/results/results_verify.php");
        break;

    case "/worksheet.php":
        require_once(__DIR__ . "/results/worksheet.php");
        break;

    case "/worksheet_custom.php":
        require_once(__DIR__ . "/results/worksheet_custom.php");
        break;



    ## /search folder
    case "/search.php":
        require_once(__DIR__ . "/search/search.php");
        break;

    case "/patient_profile.php":
        require_once(__DIR__ . "/search/patient_profile.php");
        break;

    case "/select_test_profile.php":
        require_once(__DIR__ . "/search/select_test_profile.php");
        break;

    case "/specimen_info.php":
        require_once(__DIR__ . "/search/specimen_info.php");
        break;

    case "/specimen_verify.php":
        require_once(__DIR__ . "/search/specimen_verify.php");
        break;

    case "/specimen_verify_do.php":
        require_once(__DIR__ . "/search/specimen_verify_do.php");
        break;

    case "/specimen_result.php":
        require_once(__DIR__ . "/search/specimen_result.php");
        break;

    case "/specimen_result_do.php":
        require_once(__DIR__ . "/search/specimen_result_do.php");
        break;

    case "/viewPatientInfo.php":
        require_once(__DIR__ . "/search/viewPatientInfo.php");
        break;



    ## /export folder
    case "/export_word.php":
        require_once(__DIR__ . "/export/export_word.php");
        break;

    case "/export_word_aggregate.php":
        require_once(__DIR__ . "/export/export_word_aggregate.php");
        break;

    case "/export_txt.php":
        require_once(__DIR__ . "/export/export_txt.php");
        break;

    case "/export_pdf.php":
        require_once(__DIR__ . "/export/export_pdf.php");
        break;

    case "/data_backup_revert.php":
        require_once(__DIR__ . "/export/data_backup_revert.php");
        break;

    case "/update_database.php":
        require_once(__DIR__ . "/export/update_database.php");
        break;

    case "/export_config":
        require_once(__DIR__ . "/export/export_config.php");
        break;

    case "/exportLabConfiguration.php":
        require_once(__DIR__ . "/export/exportLabConfiguration.php");
        break;

    case "/updateCountryDatabase.php":
        require_once(__DIR__ . "/export/updateCountryDatabase.php");
        break;

    case "/updateNationalDatabaseUI.php":
        require_once(__DIR__ . "/export/updateNationalDatabaseUI.php");
        break;

    case "/exportNationalDatabaseUI.php":
        require_once(__DIR__ . "/export/exportNationalDatabaseUI.php");
        break;

    case "/backupData.php":
        require_once(__DIR__ . "/export/backupData.php");
        break;

    case "/backupDataUI.php":
        require_once(__DIR__ . "/export/backupDataUI.php");
        break;

    case "/lab_backups.php":
        require_once(__DIR__ . "/export/lab_backups.php");
        break;

    case "/export/backups/(.+\.zip)":
        require_once(__DIR__ . "/export/get_file.php?f=backups/$1");
        break;

    case "/export_to_excel.php":
        require_once(__DIR__ . "/export/export_to_excel.php");
        break;

    case "/export_to_excel_get_test_types.php":
        require_once(__DIR__ . "/export/export_to_excel_get_test_types.php");
        break;

    case "/export_excel_dailylog.php":
        require_once(__DIR__ . "/export/export_excel_dailylog.php");
        break;



    ## /users folder
    case "/edit_profile.php":
        require_once(__DIR__ . "/users/edit_profile.php");
        break;

    case "/change_profile.php":
        require_once(__DIR__ . "/users/change_profile.php");
        break;

    case "/change_pwd.php":
        require_once(__DIR__ . "/users/change_pwd.php");
        break;

    case "/password_reset.php":
        require_once(__DIR__ . "/users/password_reset.php");
        break;

    case "/oneTime_password_reset.php":
        require_once(__DIR__ . "/users/oneTime_password_reset.php");
        break;

    case "/lab_admins.php":
        require_once(__DIR__ . "/users/lab_admins.php");
        break;

    case "/lab_admin_new.php":
        require_once(__DIR__ . "/users/lab_admin_new.php");
        break;

    case "/lab_admin_edit.php":
        require_once(__DIR__ . "/users/lab_admin_edit.php");
        break;

    case "/lab_user_new.php":
        require_once(__DIR__ . "/users/lab_user_new.php");
        break;

    case "/lab_user_edit.php":
        require_once(__DIR__ . "/users/lab_user_edit.php");
        break;

    case "/lab_user_type_new.php":
        require_once(__DIR__ . "/users/lab_user_type_new.php");
        break;

    case "/lab_user_type_edit.php":
        require_once(__DIR__ . "/users/lab_user_type_edit.php");
        break;

    case "/switchto_admin.php":
        require_once(__DIR__ . "/users/switchto_admin.php");
        break;

    case "/switchto_tech.php":
        require_once(__DIR__ . "/users/switchto_tech.php");
        break;

    case "/login.php":
        require_once(__DIR__ . "/users/login.php");
        break;

    case "/validate.php":
        require_once(__DIR__ . "/users/validate.php");
        break;

    case "/logout.php":
        require_once(__DIR__ . "/users/logout.php");
        break;

    case "/home.php":
        require_once(__DIR__ . "/users/home.php");
        break;

    case "/accesslist.php":
        require_once(__DIR__ . "/users/accesslist.php");
        break;


    case "/passwordReset.php":
        require_once(__DIR__ . "/users/passwordReset.php");
        break;



    ## /feedback folder
    case "/comments.php":
        require_once(__DIR__ . "/feedback/comments.php");
        break;

    case "/latency_table.php":
        require_once(__DIR__ . "/feedback/latency_table.php");
        break;

    case "/login_table.php":
        require_once(__DIR__ . "/feedback/login_table.php");
        break;

    case "/record\.js":
        require_once(__DIR__ . "/feedback/record.js");
        break;

    case "/blank\.txt":
        require_once(__DIR__ . "/feedback/blank.txt");
        break;

    case "/Latency.php":
        require_once(__DIR__ . "/feedback/Latency.php");
        break;

    case "/UserProps.php":
        require_once(__DIR__ . "/feedback/UserProps.php");
        break;

    case "/user_rating.php":
        require_once(__DIR__ . "/feedback/user_rating.php");
        break;

    case "/user_rating_submit.php":
        require_once(__DIR__ . "/feedback/user_rating_submit.php");
        break;



    ## /help folder
    case "/help.php":
        require_once(__DIR__ . "/feedback/help.php");
        break;



    ## /lang folder
    case "/lang_switch":
        require_once(__DIR__ . "/lang/lang_switch.php");
        break;

    case "/stock_add.php":
        require_once(__DIR__ . "/lang/stock_add.php");
        break;

    case "/stock_details.php":
        require_once(__DIR__ . "/lang/stock_details.php");
        break;

    case "/stock_edit.php":
        require_once(__DIR__ . "/lang/stock_edit.php");
        break;

    case "/stock_edit_details.php":
        require_once(__DIR__ . "/lang/stock_edit_details.php");
        break;

    case "/stock_update.php":
        require_once(__DIR__ . "/lang/stock_update.php");
        break;

    case "/lang_edit":
        require_once(__DIR__ . "/lang/lang_edit.php");
        break;

    case "/lang_update":
        require_once(__DIR__ . "/lang/lang_update.php");
        break;

    case "/lang_catalog_update":
        require_once(__DIR__ . "/lang/lang_catalog_update.php");
        break;

    case "/lang_xml2php":
        require_once(__DIR__ . "/lang/lang_xml2php.php");
        break;

    case "/remarks_edit.php":
        require_once(__DIR__ . "/lang/remarks_edit.php");
        break;

    case "/stock_management":
        require_once(__DIR__ . "/lang/stock_management.php");
        break;

    case "/remarks_update.php":
        require_once(__DIR__ . "/lang/remarks_update.php");
        break;

    case "/current_inventory.php":
        require_once(__DIR__ . "/lang/current_inventory.php");
        break;

    case "/stock_out.php":
        require_once(__DIR__ . "/lang/stock_out.php");
        break;


    ## /update folder
    case "/update.php":
        require_once(__DIR__ . "/update/update.php");
        break;

    case "/updateCountryDbAtLocalUI.php":
        require_once(__DIR__ . "/update/updateCountryDbAtLocalUI.php");
        break;

    case "/updateCountryDbAtLocal.php":
        require_once(__DIR__ . "/update/updateCountryDbAtLocal.php");
        break;


    ## /debug folder
    case "/testsuite_backend":
        require_once(__DIR__ . "/debug/testsuite_backend.php");
        break;


    ## /inventory folder
    case "/new_reagent.php":
        require_once(__DIR__ . "/inventory/new_reagent.php");
        break;

    case "/new_stock.php":
        require_once(__DIR__ . "/inventory/new_stock.php");
        break;

    case "/inv_new_reagent.php":
        require_once(__DIR__ . "/inventory/inv_new_reagent.php");
        break;

    case "/inv_new_stock.php":
        require_once(__DIR__ . "/inventory/inv_new_stock.php");
        break;

    case "/use_stock.php":
        require_once(__DIR__ . "/inventory/use_stock.php");
        break;

    case "/edit_stock.php":
        require_once(__DIR__ . "/inventory/edit_stock.php");
        break;

    case "/edit_lot.php":
        require_once(__DIR__ . "/inventory/edit_lot.php");
        break;

    case "/view_stock.php":
        require_once(__DIR__ . "/inventory/view_stock.php");
        break;

    case "/view_stocks.php":
        require_once(__DIR__ . "/inventory/view_stocks.php");
        break;

    case "/stock_lots.php":
        require_once(__DIR__ . "/inventory/stock_lots.php");
        break;


    ## /barcode folder
    case "/generate_barcode.php":
        require_once(__DIR__ . "/barcode/generate_barcode.php");
        break;

    case "/barcode_lib.php":
        require_once(__DIR__ . "/barcode/barcode_lib.php");
        break;

    case "/export_to_pdf.php":
        require_once(__DIR__ . "/barcode/tcpdf/export_to_pdf.php");
        break;

    case "/print_barcode.php":
        require_once(__DIR__ . "/barcode/print_barcode.php");
        break;

    case "/get_barcode.php":
        require_once(__DIR__ . "/barcode/get_barcode.php");
        break;


    ## /billing folder
    case "/bill_generator.php":
        require_once(__DIR__ . "/billing/bill_generator.php");
        break;

    case "/bill_review.php":
        require_once(__DIR__ . "/billing/bill_review.php");
        break;

    case "/create_new_bill.php":
        require_once(__DIR__ . "/billing/create_new_bill.php");
        break;

    case "/update_discount_for_association.php":
        require_once(__DIR__ . "/billing/update_discount_for_association.php");
        break;


    ## /director folder
    case "/lab_pin.php":
        require_once(__DIR__ . "/director/lab_pin.php");
        break;

    case "/geo_report_dir.php":
        require_once(__DIR__ . "/director/geo_report_dir.php");
        break;

    case "/update_lab_coords.php":
        require_once(__DIR__ . "/director/update_lab_coords.php");
        break;


    ## /bulk_print folder
    case "/print_page.php":
        require_once(__DIR__ . "/bulk_print/print_page.php");
        break;

    case "/report_content.php":
        require_once(__DIR__ . "/bulk_print/report_content.php");
        break;

    case "/print_functions.php":
        require_once(__DIR__ . "/bulk_print/print_functions.php");
        break;

    case "/report_word_content.php":
        require_once(__DIR__ . "/bulk_print/report_word_content.php");
        break;


    ## Debug tooling
    case "/debug.php":
        require_once(__DIR__ . "/debug/debug.php");
        break;

    default:
        include_once(__DIR__ . $request);
}
