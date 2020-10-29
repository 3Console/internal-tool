<template>
    <div>
                <div id="footer" class="footer w3-container w3-white">

            <hr>

            <div style="overflow:auto">
                <div class="bottomad">
                    <div id="snhb-bottom_medium_rectangle-0" style="padding:0 10px 10px 0;float:left;width:auto;"></div>
                    <div id="snhb-right_bottom_medium_rectangle-0" style="padding:0 10px 10px 0;float:left;width:auto;"></div>
                </div>
            </div>

            <hr>
            <div class="w3-row-padding w3-center w3-small" style="margin:0 -16px">
                <div class="w3-col l3 m3 s12">
                    <a class="w3-button w3-light-grey w3-block" href="javascript:void(0);" onclick="displayError();return false" style="white-space:nowrap;text-decoration:none;margin-top:1px;margin-bottom:1px">REPORT ERROR</a>
                </div>
                <div class="w3-col l3 m3 s12">
                    <a class="w3-button w3-light-grey w3-block" href="javascript:void(0);" target="_blank" onclick="printPage();return false;" style="text-decoration:none;margin-top:1px;margin-bottom:1px">PRINT PAGE</a>
                </div>
                <div class="w3-col l3 m3 s12">
                    <a class="w3-button w3-light-grey w3-block" href="/forum/default.asp" target="_blank" style="text-decoration:none;margin-top:1px;margin-bottom:1px">FORUM</a>
                </div>
                <div class="w3-col l3 m3 s12">
                    <a class="w3-button w3-light-grey w3-block" href="/about/default.asp" target="_top" style="text-decoration:none;margin-top:1px;margin-bottom:1px">ABOUT</a>
                </div>

            </div>
            <div class="w3-container w3-light-grey w3-padding" id="err_sent" style="display:none;position:relative">
                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <h2>Thank You For Helping Us!</h2>
                <p>Your message has been sent to W3Schools.</p>
            </div>

            <div class="w3-row w3-center w3-small">
                <div class="w3-col l3 m6 s12">
                    <div class="top10">
                        <h4>Top Tutorials</h4>
                        <a href="/html/default.asp">HTML Tutorial</a><br>
                        <a href="/css/default.asp">CSS Tutorial</a><br>
                        <a href="/js/default.asp">JavaScript Tutorial</a><br>
                        <a href="/howto/default.asp">How To Tutorial</a><br>
                        <a href="/sql/default.asp">SQL Tutorial</a><br>
                        <a href="/python/default.asp">Python Tutorial</a><br>
                        <a href="/w3css/default.asp">W3.CSS Tutorial</a><br>
                        <a href="/bootstrap/bootstrap_ver.asp">Bootstrap Tutorial</a><br>
                        <a href="/php/default.asp">PHP Tutorial</a><br>
                        <a href="/jquery/default.asp">jQuery Tutorial</a><br>
                        <a href="/java/default.asp">Java Tutorial</a><br>
                        <a href="/cpp/default.asp">C++ Tutorial</a><br>
                    </div>
                </div>
                <div class="w3-col l3 m6 s12">
                    <div class="top10">
                        <h4>Top References</h4>
                        <a href="/tags/default.asp">HTML Reference</a><br>
                        <a href="/cssref/default.asp">CSS Reference</a><br>
                        <a href="/jsref/default.asp">JavaScript Reference</a><br>
                        <a href="/sql/sql_ref_keywords.asp">SQL Reference</a><br>
                        <a href="/python/python_reference.asp">Python Reference</a><br>
                        <a href="/w3css/w3css_references.asp">W3.CSS Reference</a><br>
                        <a href="/bootstrap/bootstrap_ref_all_classes.asp">Bootstrap Reference</a><br>
                        <a href="/php/php_ref_overview.asp">PHP Reference</a><br>
                        <a href="/colors/colors_names.asp">HTML Colors</a><br>
                        <a href="/jquery/jquery_ref_overview.asp">jQuery Reference</a><br>
                        <a href="/java/java_ref_keywords.asp">Java Reference</a><br>
                        <a href="/angular/angular_ref_directives.asp">Angular Reference</a><br>
                    </div>
                </div>
                <div class="w3-col l3 m6 s12">
                    <div class="top10">
                        <h4>Top Examples</h4>
                        <a href="/html/html_examples.asp">HTML Examples</a><br>
                        <a href="/css/css_examples.asp">CSS Examples</a><br>
                        <a href="/js/js_examples.asp">JavaScript Examples</a><br>
                        <a href="/howto/default.asp">How To Examples</a><br>
                        <a href="/sql/sql_examples.asp">SQL Examples</a><br>
                        <a href="/python/python_examples.asp">Python Examples</a><br>
                        <a href="/w3css/w3css_examples.asp">W3.CSS Examples</a><br>
                        <a href="/bootstrap/bootstrap_examples.asp">Bootstrap Examples</a><br>
                        <a href="/php/php_examples.asp">PHP Examples</a><br>
                        <a href="/jquery/jquery_examples.asp">jQuery Examples</a><br>
                        <a href="/java/java_examples.asp">Java Examples</a><br>
                        <a href="/xml/xml_examples.asp">XML Examples</a><br>
                    </div>
                </div>
                <div class="w3-col l3 m6 s12">
                    <div class="top10">
                        <h4>Web Certificates</h4>
                        <a href="/cert/default.asp">HTML Certificate</a><br>
                        <a href="/cert/default.asp">CSS Certificate</a><br>
                        <a href="/cert/default.asp">JavaScript Certificate</a><br>
                        <a href="/cert/default.asp">SQL Certificate</a><br>
                        <a href="/cert/default.asp">Python Certificate</a><br>
                        <a href="/cert/default.asp">jQuery Certificate</a><br>
                        <a href="/cert/default.asp">PHP Certificate</a><br>
                        <a href="/cert/default.asp">Bootstrap Certificate</a><br>
                        <a href="/cert/default.asp">XML Certificate</a><br>
                        <a href="//www.w3schools.com/cert/default.asp" class="w3-button w3-margin-top w3-dark-grey" style="text-decoration:none">
                            Get Certified &raquo;</a>

                    </div>
                </div>
            </div>

            <hr>
            <div class="w3-center w3-small w3-opacity">
                W3Schools is optimized for learning, testing, and training. Examples might be simplified to improve reading and basic understanding.
                Tutorials, references, and examples are constantly reviewed to avoid errors, but we cannot warrant full correctness of all content.
                While using this site, you agree to have read and accepted our <a href="/about/about_copyright.asp">terms of use</a>,
                <a href="/about/about_privacy.asp">cookie and privacy policy</a>.
                <a href="/about/about_copyright.asp">Copyright 1999-2020</a> by Refsnes Data. All Rights Reserved.<br>
                <a href="//www.w3schools.com/w3css/default.asp">Powered by W3.CSS</a>.<br><br>
                <a href="//www.w3schools.com">
                    <img style="width:150px;height:28px;border:0" src="/images/w3schoolscom_gray.gif" alt="W3Schools.com"></a>
            </div>
            <br><br>
        </div>
    </div>
</template>
<script>
export default {
    
}
</script>