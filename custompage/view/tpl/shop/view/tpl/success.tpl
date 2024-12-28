<!-- ============================================ -->
<!--                 Navigation                   -->
<!-- ============================================ -->

<header id="cs-navigation">
    <div class="cs-container">
        <!--Nav Logo-->
        <a href="" class="cs-logo" aria-label="back to home">
            <img src="addon/custompage/images/techsero-logo-plain-reverse.png" alt="logo" !width="210" height="50" aria-hidden="true" decoding="async">
        </a>
        <!--Navigation List-->
        <nav class="cs-nav" role="navigation">
            <!--Mobile Nav Toggle-->
            <button class="cs-toggle" aria-label="mobile menu toggle">
                <div class="cs-box" aria-hidden="true">
                    <span class="cs-line cs-line1" aria-hidden="true"></span>
                    <span class="cs-line cs-line2" aria-hidden="true"></span>
                    <span class="cs-line cs-line3" aria-hidden="true"></span>
                </div>
            </button>
            <!-- We need a wrapper div so we can set a fixed height on the cs-ul in case the nav list gets too long from too many dropdowns being opened and needs to have an overflow scroll. This wrapper acts as the background so it can go the full height of the screen and not cut off any overflowing nav items while the cs-ul stops short of the bottom of the screen, which keeps all nav items in view no matter how mnay there are-->
            <div class="cs-ul-wrapper">
                <ul id="cs-expanded" class="cs-ul" aria-expanded="false">

                    <li class="cs-li">
                        <a href="/" class="cs-li-link">
                            Home
                        </a>
                    </li>
                    <li class="cs-li">
                        <a href="/hubzilla" class="cs-li-link">
                            Managed Hubzilla
                        </a>
                    </li>
                    <li class="cs-li">
                        <a href="/webdesign" class="cs-li-link">
                            Custom Websites
                        </a>
                    </li>                    
                    <!--
                    <li class="cs-li">
                        <a href="/contentcreation" class="cs-li-link">
                            Content Creation
                        </a>
                    </li>
                    -->
                    <li class="cs-li">
                        <a href="/webservices" class="cs-li-link">
                            Web Services
                        </a>
                    </li>   
                    
                    <!--Copy and paste this cs-dropdown list item and replace any .cs-li with this cs-dropdown group to make a new dropdown and it will work-->
                    <!--
                    <li class="cs-li cs-dropdown" tabindex="0">
                        <span class="cs-li-link">
                            Services
                            <img class="cs-drop-icon" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons/down-gold.svg" alt="dropdown icon" width="15" height="15" decoding="async" aria-hidden="true">
                        </span>
                        <ul class="cs-drop-ul">
                            <li class="cs-drop-li">
                                <a href="" class="cs-li-link cs-drop-link">Highlights</a>
                            </li>
                            <li class="cs-drop-li">
                                <a href="" class="cs-li-link cs-drop-link">Women's Hair Cuts</a>
                            </li>
                        </ul>
                    </li>                    
                    -->
                    
                </ul>
            </div>
        </nav>
        <a href="https://techsero.net/clientarea.php" class="cs-button-solid cs-nav-button">Dashboard</a>
        <!--Dark Mode toggle, uncomment button code if you want to enable a dark mode toggle-->
        <!-- <button id="dark-mode-toggle" aria-label="dark mode toggle">
            <svg class="cs-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 480" style="enable-background:new 0 0 480 480" xml:space="preserve"><path d="M459.782 347.328c-4.288-5.28-11.488-7.232-17.824-4.96-17.76 6.368-37.024 9.632-57.312 9.632-97.056 0-176-78.976-176-176 0-58.4 28.832-112.768 77.12-145.472 5.472-3.712 8.096-10.4 6.624-16.832S285.638 2.4 279.078 1.44C271.59.352 264.134 0 256.646 0c-132.352 0-240 107.648-240 240s107.648 240 240 240c84 0 160.416-42.688 204.352-114.176 3.552-5.792 3.04-13.184-1.216-18.496z"/></svg>
            <img class="cs-sun" aria-hidden="true" src="https://csimg.nyc3.cdn.digitaloceanspaces.com/Icons%2Fsun.svg" decoding="async" alt="moon" width="15" height="15">
        </button> -->
    </div>
</header>

<section id="services-1378">
    <div class="cs-container">
        <div class="cs-content">
            <h3>Thank you for your payment!</h3>
            <p class="cs-text pb-3">We've received your payment, and your subscription has automatically been activated.<br><a href="{{$plans[$paymentAmt]}}">Start enjoying your subscriber-exclusive content now!</a></p>
            {{if !empty($txData)}}
                <h5 class="pt-3 mb-0">Transaction Details</h5>
                <table class="cs-transaction-details">
                    <tr>
                        <th>Detail</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Transaction ID</td>
                        <td>{{$txData['txn_id']}}</td>
                    </tr>
                    <tr>
                        <td>Payment Status</td>
                        <td>{{strtoupper($txData['payment_status'])}}</td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td>{{$txData['payment_gross']}} {{$txData['mc_currency']}}</td>
                    </tr>
                    <tr>
                        <td>Plan</td>
                        <td>{{ucfirst($plans[$txData['payment_gross']])}} ({{$termLength}} {{$termUnits}})</td>
                    </tr>
                    <tr>
                        <td>Account Email</td>
                        <td>{{$acctEmail}}</td>
                    </tr>
                    <tr>
                        <td>Payment Date</td>
                        <td>
                            {{if empty($duplicate)}}
                                {{date("Y-m-d H:i:s", time())}}
                            {{else}}
                                {{$duplicate['sub_created']}}
                            {{/if}}
                        </td>
                    </tr>
                    <tr>
                        <td>Expiry Date</td>
                        <td>
                            {{if empty($duplicate)}}
                                {{date("Y-m-d H:i:s", strtotime("+1 $termUnits"))}}
                            {{else}}
                                {{$duplicate['sub_expires']}}
                            {{/if}}
                        </td>
                    </tr> 
                </table> 
            {{/if}}          
        </div>
    </div>
</section>