<!DOCTYPE html>
<html lang="en-UK" >
    <head>
        <meta charset="utf-8"/>

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="//www.ibm.com/favicon.ico" />

    	<link rel="canonical" href="http://www.ibm.com/link_label_1.html" />
    	<meta name="geo.country" content="UK" />
    	<meta name="dcterms.rights" content="� Copyright IBM Corp. 2020" />
    	<meta name="dcterms.date" content="REPLACE" />
    	<meta name="description" content="REPLACE" />
    	<meta name="keywords" content="REPLACE" />
    	<meta name="robots" content="index, follow" />

        <meta name="generator" content="IBM Northstar Template Generator 2.0" />
        <title>{{ config('app.name') }}</title>

    	{{-- <script type="text/javascript">
    		digitalData = {
            	page: {
                    category: {
                    	primaryCategory: "SB03"
                    },
                    pageInfo: {
                    	author: "Piotr Tajanowicz",
                        effectiveDate: "2014-11-19",
                        expiryDate: "2030-11-19",
                        language: "en-US",
                        publishDate: "2014-11-19",
                        publisher: "IBM Corporation",
                        version: "v18",
                        ibm: {
                            contentDelivery: "HTML",
                            contentProducer: "IBM Northstar Template Generator 2.0",
                            country: "UK",
                            industry: "______",
                            owner: "Piotr Tajanowicz/Poland/IBM",
                            owningPortal: "______",
                            siteID: "______",
                            subject: "______",
                            type: "CT###"
                        }
                    },
                },
                meta: {
                    page: ""
                }
        	};
    	</script> --}}
        <script src="//1.www.s81c.com/common/stats/ida_stats.js"></script>
        <link href="//1.www.s81c.com/common/v18/css/www.css" rel="stylesheet" />
        <link href="//1.www.s81c.com/common/v18/css/grid-fluid.css" rel="stylesheet">
        <script src="//1.www.s81c.com/common/v18/js/www.js"></script>

    	<link href="//1.www.s81c.com/common/v18/css/forms.css" rel="stylesheet">
    	<script src="//1.www.s81c.com/common/v18/js/forms.js"></script>

        <link href="//1.www.s81c.com/common/v18/css/tables.css" rel="stylesheet">
        <script src="//1.www.s81c.com/common/v18/js/tables.js"></script>

        <script src="//1.www.s81c.com/common/v18/js/dyntabs.js"></script>
        <script src="//1.www.s81c.com/common/v18/js/d3.js"></script>

        <!-- <script src="vendor/components/jquery/jquery.min.js"></script> -->
        <script type="text/javascript">
            window.$ = window.jQuery;
            window.appUrl = "{{ url('/') }}";
            window.apiUrl = "{{ url('/') }}/api/";
        </script>

        <script src="{{ asset('js/tinymce/tinymce.min.js')}}"></script>

        <script type="module" src="{{ asset('js/app.js')}}"></script>

        <!-- new version of bluepages typahead lookup feature -->
        <script src="{{ asset('handlebars/js/handlebars-v4.0.11.js')}}"></script>
        <script src="{{ asset('typeahead/js/bloodhound.min.js')}}"></script>
        <script src="{{ asset('typeahead/js/typeahead.bundle.min.js')}}"></script>

        <!-- un-comment if using the bluepages typahead lookup feature (formUserID uses this function) -->
        <!-- if using modals or overlays this css file must appear before the application css and the application css must change the z-index of typeahead-results to a high value eg 10000 -->
        <!-- <link href="vendor/facesTypeahead/css/facestypeahead-0.4.4.min.css" rel="stylesheet"> -->
        <link href="{{ asset('typeahead/css/typeahead.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('css/app.css')}}" rel="stylesheet">

    	<script type="text/javascript">
        	IBMCore.common.util.config.set({
        		masthead: {
                  type: "mobile"
                },
                backtotop: {
                    enabled: true
                },
        		footer: {
        	        socialLinks: {
        	            enabled: false
        	        }
        	    },
        	});
    	 </script>
    </head>
    <body id="ibm-com" class="ibm-type">
        <div id="ibm-top" class="ibm-landing-page">

          	<x-master-head/>

            <div id="ibm-content-wrapper">

                <x-lead-space/>

                <main role="main" aria-labelledby="ibm-pagetitle-h1">
                    <div id="ibm-pcon">
                        <div id="ibm-content">
                            <div id="ibm-content-body" class="ibm-padding-top-1">
                                <div id="ibm-content-main">

                                    <div class="ibm-fluid">
                                        <div class="ibm-col-12-2">

                                        <x-navigation/>

                                    	</div>
                                        <div class="ibm-col-12-10">

                                    	@hasSection('content')
                                            @yield('content')
                                        @endif

                                    	@hasSection('title')
                                            @yield('title')
                                        @endif

                                        @hasSection('code')
                                            @yield('code')
                                        @endif

                                    	@hasSection('message')
                                            @yield('message')
                                        @endif

                                    	</div>
                                    </div>
                                    @hasSection('bottom-section')
                                    <div class="ibm-fluid ibm-fullwidth">
                                        <div class="ibm-col-12-12">
                                            @yield('bottom-section')
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <div id="ibm-related-content">
                    <div id="ibm-merchandising-module">
                        <!-- MTE will generate this -->
                        <!-- <aside role="complementary" aria-label="Related content"> MTE dynamic modules populate in here. <aside> -->
                        <!-- /MTE -->
                    </div>
                </div>

            </div>

            <div id="spinner"></div>

            <!-- Global Page Overlays -->
            @include('components/modals/info')
            @include('components/modals/overlay')
            <!-- End Global Page Overlays -->

        	@include('partials.footer')

        </div>
    </body>
</html>
