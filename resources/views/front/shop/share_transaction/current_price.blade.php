@extends('layouts.main')
@section('head')
<!-- Alert -->
<link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.css') }}">
<!-- Loading -->
<link rel="stylesheet" href="{{ asset('plugins/HoldOn/HoldOn.min.css') }}"> 
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">

<style>
        
    /*上方menu顯示title版本*/
    .m-bar-nav-close-bg {
        display: none;
    }
    
    .m-bar-nav-close-bg-title {
        display: block !important;
    }
    
    .m-page-title {
        display: block !important;
    }
        
    /*跑馬燈公告*/
    .m-marquee-position {
        display: block !important;
    }
    
    .pc-marquee-position {
        display: block !important;
    }
    
    /*bar高度設置*/
    .pc-bar-height{
        height: 65px !important;
    }

    @media screen and (min-width: 992px) and (max-width: 1399px) {
        .pc-bar-height{
            height: 53px !important;
        }
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        .pc-bar-height{
            height: 43px !important;
        }
    }

    /*i7plus*/
    @media screen and (min-width: 414px) and (max-width: 767px) {
        
        .m-top-margin{
            height: 43px !important;
        }
        
    }
    
    /*i7大小～plus以下 & Android主流螢幕*/
    @media screen and (min-width: 360px) and (max-width: 413px) {
        
        .m-top-margin{
            height: 38px !important;
        }
        
    }
    
    
    /*i5大小*/
    @media screen and (max-width: 359px) {
        
        .m-top-margin{
            height: 33px !important;
        }
        
    }
    
    
    /*上方資訊區背景色*/
    .share-title-area {
        background-color: #008CC8;
    }
    
    /*表單抬頭標題顏色*/
    .share-table-title {
        color: #00A3E0;
    }
    
    #data_list {
        position: relative;
        margin-bottom: 0;
    }
    
    table.dataTable thead > tr > th {
        font-size: 20px;
        height: 45px;
        text-align: center;
        color: #2E2B4A;
    }
    
    table.dataTable thead > tr {
        border-left: 10px solid rgba(255, 255, 255, 0);
        border-bottom: 4px solid #2E2B4A;
    }
    
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after {
        right: 35%;
    }
    
    .table > tbody > tr > td {
        padding: 0;
        height: 70px;
        line-height: 70px;
        text-align: center;
        font-size: 22px;
        color: #2E2B4A;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
        border: 0;
    }
    
    tr:nth-child(2n+1) {
	    background-color: #FFF;
        border-left: 10px solid #4CC5F2;
	}
    
    tr:nth-child(2n+2) {
	    background-color: #CACBCC;
        border-left: 10px solid #2E2B4A;
	}
    
    tr:last-child {
        border-bottom: 4px solid #2E2B4A;
    }
    
    .buy img {
        height: 32px;
        margin-top: 19px;
        cursor: pointer;
    }
    
    .cancel img {
        height: 32px;
        margin-top: 19px;
        cursor: pointer;
    }
    
    .buy_item {
        width: 60px;
        height: 32px;
        background: url("{{ asset('front/img/share/table_buy_blue.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin: 0 auto;
        margin-top:19px;
    }
    
    .table-right-border {
        position: absolute;
        right: -1.5px;
        top: 12px;
        width: 3px;
        height: 22px;
        background-color: #2E2B4A;
    }
    
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 32%;
        }
    }
    
    @media screen and (min-width: 992px) and (max-width: 1199px) {

        table.dataTable thead > tr > th {
            font-size: 18px;
            height: 40px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 32%;
        }

        .table > tbody > tr > td {
            height: 60px;
            line-height: 60px;
            font-size: 20px;
        }
        
        .buy img {
            height: 30px;
            margin-top: 15px;
        }
        
        .cancel img {
            height: 30px;
            margin-top: 15px;
        }
        
        .buy_item {
            width: 57px;
            height: 30px;
            margin-top: 15px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 10px;
            width: 3px;
            height: 20px;
        }
        
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        
        table.dataTable thead > tr > th {
            font-size: 16px;
            height: 36px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 32%;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 18px;
        }
        
        .buy img {
            height: 26px;
            margin-top: 12px;
        }
        
        .cancel img {
            height: 26px;
            margin-top: 12px;
        }
                 
        .buy_item {
            width: 50px;
            height: 26px;
            margin-top: 12px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 9px;
            width: 3px;
            height: 20px;
        }
        
    }

    /*i7plus*/
    @media screen and (min-width: 414px) and (max-width: 767px) {
        
        table.dataTable thead > tr > th {
            font-size: 14px;
            height: 36px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 8px;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 16px;
        }
        
        .buy img {
            height: 26px;
            margin-top: 12px;
        }
        
        .cancel img {
            height: 26px;
            margin-top: 12px;
        }
        
        .buy_item {
            width: 50px;
            height: 26px;
            margin-top: 12px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 9px;
            width: 3px;
            height: 20px;
        }
        
    }
    
    /*i7大小～plus以下 & Android主流螢幕*/
    @media screen and (min-width: 360px) and (max-width: 413px) {
        
        table.dataTable thead > tr > th {
            font-size: 14px;
            height: 36px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 8px;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 16px;
        }
        
        .buy img {
            height: 26px;
            margin-top: 12px;
        }
                   
        .cancel img {
            height: 26px;
            margin-top: 12px;
        }
        
        .buy_item {
            width: 50px;
            height: 26px;
            margin-top: 12px;
        }
        
        .table-right-border {
            right: -1.5px;
            top: 9px;
            width: 3px;
            height: 20px;
        }
        
    }
    
    
    /*i5大小*/
    @media screen and (max-width: 359px) {
        
        table.dataTable thead > tr > th {
            font-size: 12px;
            height: 36px;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            right: 8px;
        }

        .table > tbody > tr > td {
            height: 50px;
            line-height: 50px;
            font-size: 14px;
        }
        
        .buy img {
            height: 22px;
            margin-top: 14px;
        }
        
        .cancel img {
            height: 22px;
            margin-top: 14px;
        }
                   
        .buy_item {
            width: 42px;
            height: 22px;
            margin-top: 14px;
        }
        
        .table-right-border {
            right: -1px;
            top: 10px;
            width: 2px;
            height: 16px;
        }
        
    }
    
    /*購買彈出視窗*/
     
    .modal-dialog {
        width: 450px;
        margin-top: 335px;
    }
    
    .modal-content {
        border-radius: 25px;
    }
    
    .alert-coin-left , .alert-coin-right {
        display: none;
    }
    
    .model-alert-title {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        letter-spacing: 6px;
        color: #008CC8;
        padding-top: 10px;
        padding-bottom: 20px;
    }
    
    .model-alert-input {
        position: relative;
        width: 350px;
        height: 60px;
        margin: 0 auto;
        padding-right: 90px;
        margin-bottom: 10px;
    }
    
    .form-alert-input {
        height: 60px;
        line-height: 60px;
        color: white;
        background-color: #818181;
        font-size: 30px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
        text-align: center;
        border-radius: 60px;
    }
    
    .model-alert-input-text {
        position: absolute;
        height: 60px;
        line-height: 60px;
        top: 0;
        right: 0;
        color: #00A3E0;
        font-size: 30px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .model-alert-coin-plus {
        position: relative;
        width: 350px;
        height: 60px;
        line-height: 60px;
        margin: 0 auto;
        color: #00A3E0;
        font-size: 28px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .model-alert-coin-plus img {
        height: 60px;
        margin-right: 10px;
    }
    
    .model-alert-coin-use {
        position: relative;
        width: 350px;
        height: 60px;
        line-height: 60px;
        margin: 0 auto;
        color: #D4A435;
        font-size: 28px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
    }
    
    .model-alert-coin-use img {
        height: 60px;
        margin-right: 10px;
    }
    
    .model-btn-area {
        margin-top: 40px;
    }
        
    .btn-gray {
        color: #fff;
        background-color: #58595B;
        border: 1px solid #58595B;
        padding: 2px 18px;
        font-size: 18px;
    }
    
    .btn-gray:hover , .btn-gray:focus {
        color: #fff;
        background-color: #58595B;
        border: 1px solid #58595B;
        padding: 2px 18px;
        font-size: 18px;
    }
    
    .btn-red {
        color: #fff;
        background-color: #E4002B;
        border: 1px solid #E4002B;
        padding: 2px 18px;
        font-size: 18px;
    }
    
    .btn-red:hover , .btn-red:focus {
        color: #fff;
        background-color: #58595B;
        border: 1px solid #58595B;
        padding: 2px 18px;
        font-size: 18px;
    }
    
    
    @media screen and (min-width: 1200px) and (max-width: 1399px) {
        
        .modal-dialog {
            margin-top: 300px;
        }
    
    }
    
    @media screen and (min-width: 992px) and (max-width: 1199px) {
        
        .modal-dialog {
            margin-top: 300px;
        }
    
    }
    
    @media screen and (min-width: 768px) and (max-width: 991px) {
        
        .modal-dialog {
            margin-top: 220px;
        }
    
    }

    /*i7plus*/
    @media screen and (min-width: 414px) and (max-width: 767px) {
        
        .modal-dialog {
            width: 93%;
            margin: 0 auto;
            margin-top: 210px;
        }
        
        .alert-coin-left {
            display: block;
            position: absolute;
            width: 200px;
            top: -45px;
            left: 25%;
            margin-left: -100px;
        }
        
        .alert-coin-right {
           display: block;
            position: absolute;
            width: 200px;
            top: -45px;
            left: 75%;
            margin-left: -100px; 
        }
        
        .model-alert-title {
            font-size: 28px;
            letter-spacing: 3px;
            padding-top: 10px;
            padding-bottom: 15px;
        }
        
        .model-alert-input {
            width: 320px;
            height: 42px;
            margin: 0 auto;
            padding-right: 70px;
            margin-bottom: 10px;
        }

        .form-alert-input {
            height: 42px;
            line-height: 42px;
            font-size: 28px;
        }

        .model-alert-input-text {
            position: absolute;
            height: 42px;
            line-height: 42px;
            font-size: 28px;
        }
        
        .model-alert-coin-plus {
            width: 280px;
        }
        
        .model-alert-coin-use {
            width: 280px;
        }

    }
    
    /*i7大小～plus以下 & Android主流螢幕*/
    @media screen and (min-width: 360px) and (max-width: 413px) {
        
        .modal-dialog {
            width: 93%;
            margin: 0 auto;
            margin-top: 185px;
        }
     
        .alert-coin-left {
            display: block;
            position: absolute;
            width: 180px;
            top: -40px;
            left: 25%;
            margin-left: -90px;
        }
        
        .alert-coin-right {
            display: block;
            position: absolute;
            width: 180px;
            top: -40px;
            left: 75%;
            margin-left: -90px;
        }
        
        .model-alert-title {
            font-size: 24px;
            letter-spacing: 3px;
            padding-top: 10px;
            padding-bottom: 15px;
        }
        
        .model-alert-input {
            width: 280px;
            height: 40px;
            margin: 0 auto;
            padding-right: 65px;
            margin-bottom: 10px;
        }

        .form-alert-input {
            height: 40px;
            line-height: 40px;
            font-size: 24px;
        }

        .model-alert-input-text {
            position: absolute;
            height: 40px;
            line-height: 40px;
            font-size: 24px;
        }
        
        .model-alert-coin-plus {
            width: 240px;
            height: 48px;
            line-height: 48px;
            font-size: 24px;
        }

        .model-alert-coin-plus img {
            height: 48px;
            margin-right: 7px;
        }

        .model-alert-coin-use {
            width: 240px;
            height: 48px;
            line-height: 48px;
            font-size: 24px;
        }

        .model-alert-coin-use img {
            height: 48px;
            margin-right: 7px;
        }
        
    }
    
    
    /*i5大小*/
    @media screen and (max-width: 359px) {
        
        .modal-dialog {
            width: 93%;
            margin: 0 auto;
            margin-top: 170px;
        }
        
        .alert-coin-left {
            display: block;
            position: absolute;
            width: 140px;
            top: -30px;
            left: 25%;
            margin-left: -70px;
        }
        
        .alert-coin-right {
            display: block;
            position: absolute;
            width: 140px;
            top: -30px;
            left: 75%;
            margin-left: -70px;
        }
        
        .model-alert-title {
            font-size: 18px;
            letter-spacing: 3px;
            padding-top: 10px;
            padding-bottom: 8px;
        }
        
        .model-alert-input {
            width: 220px;
            height: 36px;
            margin: 0 auto;
            padding-right: 50px;
            margin-bottom: 10px;
        }

        .form-alert-input {
            height: 36px;
            line-height: 36px;
            font-size: 18px;
        }

        .model-alert-input-text {
            position: absolute;
            height: 36px;
            line-height: 36px;
            font-size: 18px;
        }
        
        .model-alert-coin-plus {
            width: 190px;
            height: 42px;
            line-height: 42px;
            font-size: 20px;
        }

        .model-alert-coin-plus img {
            height: 42px;
            margin-right: 5px;
        }

        .model-alert-coin-use {
            width: 190px;
            height: 42px;
            line-height: 42px;
            font-size: 20px;
        }

        .model-alert-coin-use img {
            height: 42px;
            margin-right: 5px;
        }

    }
    
    /*sweet-alert*/
    
    .sweet-alert {
        background: url("{{ asset('front/img/share/table_popup_bet_01.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        padding: 0px 35px;
        width: 360px;
        height: 500px;
        left: 50%;
        margin-left: -180px;
    }
    
    
    .sweet-alert .sa-icon {
        position: fixed;
        left: 50%;
    }
    
    .sweet-alert h2 {
        margin-top: 130px;
        margin-bottom: 0px;
        color: #5A5B5D;
    }
    
    .sweet-alert p {
        max-height: 280px;
        overflow-y: scroll;
    }
    
    .sweet-alert p::-webkit-scrollbar
    {
        width: 0px;
    }
    
    .sweet-alert button.confirm {
        background-color: #de0033 !important;
    }
    
    .sweet-alert button.cancel {
        background-color: #57585b !important;
    }
    
    .sweet-alert button {
        margin-top: 10px;
        padding: 5px 15px;
    }
    
    .sweet-alert button:hover {
        background-color: #de0033 !important;
    }
    
    .sweet-alert .sa-icon {
        width: 90px;
        height: 90px;
        margin-left: -45px;
        margin-top: 30px;
    }
    
    .sweet-alert .sa-icon.sa-warning {
        background: url("{{ asset('front/img/share/table_popup_01.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        border:0;
    }
    .sweet-alert .sa-icon.sa-warning .sa-body {
        display:none; 
    }
    .sweet-alert .sa-icon.sa-warning .sa-dot {
        display:none; 
    }
    
    .sweet-alert .sa-icon.sa-success {
        background: url("{{ asset('front/img/share/table_popup_02.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        border:0;
    }
    
    .sweet-alert .sa-icon.sa-success::before, .sweet-alert .sa-icon.sa-success::after {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success::before {
        display:none;  
    }
    .sweet-alert .sa-icon.sa-success::after {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-placeholder {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-fix {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-line {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-line.sa-tip {
        display:none;
    }
    .sweet-alert .sa-icon.sa-success .sa-line.sa-long {
        display:none;
    }
    
    .sweet-alert .sa-icon.sa-error {
        background: url("{{ asset('front/img/share/table_popup_03.gif') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        border:0;
    }
    
    .sweet-alert .sa-icon.sa-error .sa-x-mark {
        display:none;
    }
    .sweet-alert .sa-icon.sa-error .sa-line {
        display:none;
    }
    .sweet-alert .sa-icon.sa-error .sa-line.sa-left {
        display:none;
    }
    .sweet-alert .sa-icon.sa-error .sa-line.sa-right {
        display:none;
    }
    
    /*交易確認alert*/
    
    .check-unit {
        font-size: 38px;
        color: #008CC8;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
    }
    
    .check-price {
        position: relative;
        font-size: 56px;
        color: #008CC8;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
        text-align: center;
    }
    
    .check-price-icon {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
        width:30px;
        height: 35px;
        background: url("{{ asset('front/img/share/table_icon_01_blue.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin-right: 5px;
    }
    
    .check-price-info {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
    }
    
    .check-coin-plus {
        position: relative;
        width: 100%;
        height: 60px;
        line-height: 60px;
        margin: 0 auto;
        color: #00A3E0;
        font-size: 28px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
        text-align: left;
        padding-left: 90px;
    }
    
    .check-coin-plus-icon {
        position: absolute;
        top: 5px;
        left: 30px;
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/icon/currency/currency_ulg_02.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    .check-coin-use {
        position: relative;
        width: 100%;
        height: 60px;
        line-height: 60px;
        margin: 0 auto;
        color: #D4A435;
        font-size: 28px;
        font-family: Frutiger , sans-serif;
        font-weight: bold;
        font-stretch: condensed;
        text-align: left;
        padding-left: 90px;
    }
    
    .check-coin-use-icon {
        position: absolute;
        top: 5px;
        left: 30px;
        width: 50px;
        height: 50px;
        background: url("{{ asset('front/img/icon/currency/currency_gold_02.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
    }
    
    /*交易成功alert*/
    
    .success-unit {
        font-size: 38px;
        color: #38A556;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
    }
    
    .success-price {
        position: relative;
        font-size: 56px;
        color: #38A556;
        font-family: Frutiger;
        font-weight: bold;
        font-stretch: condensed;
        line-height: 120%;
        text-align: center;
    }
    
    .success-price-icon {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
        width:30px;
        height: 35px;
        background: url("{{ asset('front/img/share/table_icon_01_green.png') }}");
        background-repeat: no-repeat;
        background-size: 100% auto;
        margin-right: 5px;
    }
    
    .success-price-info {
        display: inline-block;/*讓div並排*/ 
        vertical-align: bottom;
    }
    
    .error-text {
        color: #E60B35;
        text-align: center;
        margin-top: 10px;
        font-size: 18px;
        line-height: 150%;
    }

    .sa-button-container {
        position: absolute;
        width: 100%;
        left: 0;
        bottom: 30px;
    }
    
    div.dataTables_paginate {
        text-align: center;
        margin-top: 10px;
        font-size: 18px;
    }
    
    @media screen and (max-width: 767px) {
        div.dataTables_paginate {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
        }
    }
    
    .pagination > li:first-child > a, .pagination > li:first-child > span , .pagination > li:last-child > a, .pagination > li:last-child > span {
        color: #58585B;
        border: 0;
    }
    
    .pagination > li > a, .pagination > li > span {
        border: 0;
        background-color: rgba(0,0,0,0);
        color: #58585B;
    }
    
    .pagination > li > a:hover, .pagination > li > span:hover, .pagination > li > a:focus, .pagination > li > span:focus {
        border :0;
        background-color: #FFF;
        color: #008CC8;
    }
    
    .pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
        border :0;
        background-color: #FFF;
        color: #008CC8;
    }
    
    
</style>
@stop

@section('full-size-content')

<!--背景-->
<div class="game-home-bg hidden-xs"></div>
<div class="m-game-home-bg hidden-sm hidden-md hidden-lg"></div>

<!--上方資訊顯示區-->
<div class="share-title-area">
    
    <div class="container">
        <div class="row">
            
            <!--左方牌價-->
            <div class="col-sm-6 share-title-col">
                <div class="share-title-left">  
                    <!--牌價-->
                    <div class="share-title-left-info">
                        <div class="share-title-left-info-new-title">
                            最新售價
                        </div>
                        <div class="share-title-left-info-new">
                            {{  $share_product->price }}
                        </div>
                        <div class="share-title-left-info-amount-title">商城娛樂幣餘額</div>
                        <div class="share-title-left-info-amount">{{  number_format($share['now']) }}</div>
                    </div>
                    
                    <!--幣icon-->
                    <div class="share-title-left-icon">
                        <img src="{{ asset('front/img/share/table_icon_01_white.png') }}">
                    </div>
                </div>
            </div>
            
            <!--右方餘額-->
            <div class="col-sm-5 hidden-xs">
                <div class="row coin-account-row">
                    <div class="col-xs-6" style="padding-left:0;padding-right:0;">
                        <div class="coin-account-area">
                            <div class="coin-amount-icon">
                                <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
                            </div>
                            <div class="coin-amount-font">
                                {{ number_format($cash_amount) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6" style="padding-left:0;padding-right:0;">
                        <div class="coin-account-area">
                            <div class="coin-amount-icon">
                                <img src="{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}"/>
                            </div>
                            <div class="coin-amount-font">
                                {{ number_format($share_amount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1 hidden-xs"></div>
            
        </div><!--/row-->
        
        <a class="share-btn-buy" data-toggle="modal" data-target="#buyModal"><img src="{{ asset('front/img/share/table_buy_gold.png') }}"/></a>
        
    </div><!--/container-->
    
</div>

<!--表單抬頭-->
<div class="container">
    
    <div class="share-table-title-area">
        <div class="share-table-title">玩家拍賣資訊(最低5筆)</div>
        <div id="refresh" class="share-refresh"><img src="{{ asset('front/img/share/table_icon_06_01.png') }}"/>
        </div>
        <a href="{{ route('front.shop.share_transaction.all_auction') }}">
            <div id="show_more" class="show_more"><img src="{{ asset('front/img/share/table_icon_05_01.png') }}"/>
            </div>
        </a>
    </div>
    
    <div class="share-table-area">
        <!--五筆最低價掛單-->
        <table id="data_list" class="table">
            <thead>
                <th>數量<div class="table-right-border"></div></th>
                <th>單價<div class="table-right-border"></div></th>
                <th>倒數<div class="table-right-border"></div></th>
                <th></th>
            </thead>
            <tbody>
            @foreach($datas as $data)
                <tr>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ number_format($data->quantity) }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $data->price }}</td>
                    <td style="border-right: 1.5px solid #B6B7B9;">{{ $data->time_left }}</td>
                    <td>
                        @if($data->seller_id != $user->id)
                        <a class="buy" data-id="{{ $data->id }}" data-price="{{ $data->price }}" data-quantity="{{ $data->quantity }}"><img src="{{ asset('front/img/share/table_buy_blue.png') }}"/></a>
                        @else
                        <a class="cancel" data-id="{{ $data->id }}"><img src="{{ asset('front/img/share/table_no_green.png') }}"/></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!--/.五筆最低價掛單-->
    </div>
    
    <div class="share-table-bottom-area"></div>
    
</div>

<!--
<p>本資料為 <?php echo date('m/d H') ?> 時更新，如需最新資訊，請點擊手動更新</p>
-->
@stop


<!--購買視窗-->
<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
        <!--手機顯示金幣餘額-->
        <div class="alert-coin-left">
            <div class="coin-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_gold_01.png') }}"/>
            </div>
            <div class="coin-amount-font">
                {{ number_format($cash_amount) }}
            </div>
        </div>
        <div class="alert-coin-right">
            <div class="coin-amount-icon">
                <img src="{{ asset('front/img/icon/usercoin/user_bg_ulg_01.png') }}"/>
            </div>
            <div class="coin-amount-font">
                {{ number_format($share_amount) }}
            </div>
        </div>
        
        <div class="modal-body">
            
            <div class="model-alert-title">購買娛樂幣數量</div>
            <div class="model-alert-input">
                <input type="number" class="form-alert-input form-control form-amount-input" name="unit" id="unit" maxlength="7" placeholder="單位最小為1" min="1">
                <div class="model-alert-input-text">X100</div>
            </div>
            <p id="buy_error" style="width:100%; text-align:center; padding: 5px; color#A6A8AA;"></p>
            
            <hr style="border-top:1.5px solid #848484; margin-top:5px; margin-bottom:5px;">
            
            <div class="model-alert-coin-plus">
                <img src="{{ asset('front/img/icon/currency/currency_ulg_02.png') }}"/>＋<span id="total"></span>
            </div>
            <div class="model-alert-coin-use">
                <img src="{{ asset('front/img/icon/currency/currency_gold_02.png') }}"/>－<span id="cash_total"></span>
            </div>

            <input type="hidden" class="form-control" name="product_id" id="product_id" value="{{ $share_product->id }}" required>
            <input type="hidden" class="form-control" name="price" id="price" value="{{ $share_product->price }}" required>
            
            <div class="model-btn-area">
                <center><button type="button" class="btn btn-gray" data-dismiss="modal" style="margin-right:15px;">取 消</button>
                <button class="btn btn-red" type="button" id="confirm">確 認</button></center>
            </div>

        </div>
        
    </div>
  </div>
</div>
<!--/.購買視窗-->

@section('footer-js')
<!-- main-->
<script src="{{ asset('front/js/share_transaction.js') }}"></script>
<!-- Alert-->
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<!--Loading-->
<script src="{{ asset('plugins/HoldOn/HoldOn.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="{{ asset('plugins/js-webshim/minified/polyfiller.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
   
        var table = $("#product_list");
        var product_id = $('#product_id').val();
        var share_price = $('#price').val();
        var table = $("#data_list");
        var user_id = '{{ $user->id }}';

        //千分位
        webshims.setOptions('forms-ext', {
            replaceUI: 'true',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');

        //表格初始化
        table.DataTable({
            "dom": '<"top"i>rt<"bottom"flp><"clear">',
            "order": [
                [1, "asc"]
            ],
            columns: [
                  { title: '數量<div class="table-right-border"></div>' },
                  { title: '單價<div class="table-right-border"></div>' },
                  { title: '倒數<div class="table-right-border"></div>' },
                  { title: ''  , "orderable": false},
            ],
            "pageLength": 10,
            "pagingType": "simple_numbers",
            "searching": false,
            "bLengthChange" : false,
            "bInfo" : false,
            "fnDrawCallback": function(oSettings) {
                if ($('#data_list tr').length < 11) {
                    $('.dataTables_paginate').hide();
                }
            }
        });
        

        //購買單位更動
        $('#unit').bind('input propertychange', function() {
            $('#buy_error').text("");
            if(!$(this).val() ){
                $('#total').text('')
                $('#cash_total').text('')
                return false;
            }
            if($(this).val() < 1){
                $('#buy_error').text("購買單位有誤，請重新確認");
                return false
            } 
            if($(this).val() > 999999){
                $('#buy_error').text("購買單位有誤，最多僅開放六位數，請重新確認");
                return false
            }
            if(parseInt($(this).val())!=$(this).val()){
                $('#buy_error').text("購買單位有誤，請重新確認");
                return false
            }

            $('#total').text(numeral($(this).val() * 100).format('0,0'))
            $('#cash_total').text(numeral($(this).val() * 100 * share_price).format('0,0'))
            
            
        });

        //購買
        $( "#confirm" ).click(function() {
            
            $('#buyModal').modal('hide');
            
            var unit = $('#unit').val();
            if(parseInt(unit) < 1 || !$('#unit').val()){
                swal({
                    title: '購買交易失敗',
                    text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="error-text">請重新確認購買單位</div>',
                    type: 'error',
                    html:true,
                    confirmButtonText: '確定'
                });
                return false;
            }
            quantity = unit * 100;
            total = share_price*quantity;
            swal({
                title: '購買娛樂幣金額確認',
                text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-unit">'+numeral(unit).format('0,0')+' x 100</div><div class="check-price"><div class="check-price-icon"></div><div class="check-price-info">'+share_price+'</div></div><hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-coin-plus"><div class="check-coin-plus-icon"></div>＋'+numeral(quantity).format('0,0')+'</div><div class="check-coin-use"><div class="check-coin-use-icon"></div>－'+numeral(total).format('0,0')+'</div>',
                type: 'warning',
                html:true,
                showCancelButton: true,
                confirmButtonText: '確定購買',
                cancelButtonText: '取消購買'
            },function(){

                sendUri = APP_URL + "/shop/product/buy" ;
                sendData = {'id' : product_id ,"quantity":quantity};
                shareTransactionConfirm(sendUri,sendData,quantity,total,'company_buy');
            });

        });//.購買

        //點擊手動更新
        $( "#refresh" ).click(function() {
            refreshData()

        });//.點擊手動更新

        //購買
        table.on("click", ".buy", function(e) {
            e.preventDefault();
            id = $(this).data('id');
            price = $(this).data('price');
            quantity = $(this).data('quantity');
            total = quantity*price;
            swal({
                title: '購買交易確認',
                text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-price"><div class="check-price-icon"></div><div class="check-price-info">'+price+'</div></div><hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="check-coin-plus"><div class="check-coin-plus-icon"></div>＋'+numeral(quantity).format('0,0')+'</div><div class="check-coin-use"><div class="check-coin-use-icon"></div>－'+numeral(total).format('0,0')+'</div>',
                type: 'warning',
                html:true,
                showCancelButton: true,
                confirmButtonText: '確認',
                cancelButtonText: '取消'
            },function(){
                sendUri = APP_URL + "/shop/share_transaction/deal" ;
                sendData = {'id' : id };
                shareTransactionConfirm(sendUri,sendData,quantity,total,'member_buy');
            });

        });//.購買
        
        //取消
        table.on("click", ".cancel", function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                title: '拍賣取消確認',
                text: '<hr style="border-top:2px solid #B0B0B0; margin-top:5px; margin-bottom:5px;"><div class="cancel-alert-title">\\ 注意 /</div><div class="cancel-alert-info">拍賣取消，拍賣卡將不退回</br>確認要取消此筆交易?</div>',
                type: 'warning',
                html:true,
                showCancelButton: true,
                confirmButtonText: '確認',
                cancelButtonText: '取消'
            },function(){
                sendUri = APP_URL + "/shop/share_transaction/cancel" ;
                sendData = {'id' : id };
                system_ajax(sendUri,sendData,"PUT",function(data){
                    window.location.reload();
                },function(data){});
            });

        });//.取消

        //手動更新表格資料
        function refreshData(){

          $.ajax({
            url:APP_URL + "/shop/share_transaction/cheapest_data/5",
            type : "GET",
            success:function(msg){  
                   
                var data=JSON.parse(msg);  

                dataSet= [];
                
                for(var key in data.datas){    
                    if(user_id != data.datas[key]['seller_id']){
                        btn_td = '<a class="buy" data-id="'+data.datas[key]['id']+'" data-price="'+data.datas[key]['price']+'" data-quantity="'+data.datas[key]['quantity']+'"><div class="buy_item"></div></a>';
                    } else {
                        btn_td = '<a class="cancel" data-id="'+data.datas[key]['id']+'"><img src="'+"{{ asset('front/img/share/table_no_green.png') }}"+'"/></a>'
                    }

                  table_obj = [
                    numeral(data.datas[key]['quantity']).format('0,0'),
                    data.datas[key]['price'],
                    data.datas[key]['time_left'],
                   btn_td

                  ];
                   dataSet.push(table_obj);
                }  

                //更新表格內容
                table.DataTable( {
                    "dom": '<"top"i>rt<"bottom"flp><"clear">',
                    data: dataSet,
                    columns: [
                          { title: '數量<div class="table-right-border"></div>' },
                          { title: '單價<div class="table-right-border"></div>' },
                          { title: '倒數<div class="table-right-border"></div>' },
                          { title: ''  , "orderable": false},
                    ],
                    "order": [[ 1, "asc" ]],
                    "pageLength": 10,
                    "pagingType": "simple_numbers",
                    "searching": false,
                    "bLengthChange" : false,
                    "bInfo" : false,
                    "destroy": true,
                    "fnDrawCallback": function(oSettings) {
                        if ($('#data_list tr').length < 11) {
                            $('.dataTables_paginate').hide();
                        }
                    }
                });
                
                $('#data_list tr td:nth-child(1)').css({"border-right": "1.5px solid #B6B7B9"});
                $('#data_list tr td:nth-child(2)').css({"border-right": "1.5px solid #B6B7B9"});
                $('#data_list tr td:nth-child(3)').css({"border-right": "1.5px solid #B6B7B9"});
                
                HoldOn.close();
            },
            beforeSend: function() {
                //顯示搜尋動畫
                HoldOn.open({
                    theme: 'sk-cube-grid',
                    message: "<h4>資料更新中，請稍候</h4>"
                });
            },
            error:function(xhr){
                HoldOn.close();
            }
          }); 
        }
        //.點擊手動更新
        
    });

    
</script>

@stop

