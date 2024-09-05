<footer class="navbar navbar-default">
    <div class="navbar-back-to-top" id="scrollToTop">
        <a href="">Back To Top</a>
    </div>
    <div class="navbar-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>FortniteMall.gg</h4>
                        <ul class="list-unstyled">
                            <li> <a href="#" class="noclick">About Us</a> </li>
                            <li> <a href="#" class="noclick">Contact Us</a> </li>
                            <li> <a href="#" class="noclick">Services</a> </li>
                            <li> <a href="{{route('help.paymentmethods')}}">Payment Methods</a> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>FortniteMall.gg Benefits</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" class="noclick">Cheapest prices on the market</a></li>
                            <li><a href="#" class="noclick">Loyal System</a></li>
                            <li><a href="#" class="noclick">Fast delivery</a></li>
                            <li><a href="#" class="noclick">24/7/365 customer support</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>FortniteMall.gg Guides</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" target="_blank" class="noclick">How do I receive my items</a></li>
                            <li><a href="{{route('guides.findYourEpicId')}}" target="_blank">How to find your Epic Name</a></li>
                            <li><a href="#" target="_blank" class="noclick">How to find your Discord ID</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>Follow Us</h4>
                        <ul class="list-unstyled">
                            <li><a href="https://www.youtube.com/channel/UC5EMofcR_2O5Y-ZM6Xpyz-g" target="_blank">Youtube</a></li>
                            <li><a href="https://www.instagram.com/fortnitemall.gg/" target="_blank">Instagram</a></li>
                            <li><a href="https://discord.gg/dRYfzgm" target="_blank">Discord</a></li>
                            <li><a href="https://www.facebook.com/fortnitemall.gg/" target="_blank">Facebook</a></li>
                            <li><a href="https://twitter.com/FortnitemallGG" target="_blank">Twitter</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-6">
                    <div class="footer-widget footer-widget-links">
                        <h4>Earn Money</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" target="_blank" class="noclick">Sponsorship</a></li>
                            <li><a href="#" target="_blank" class="noclick">Referral system</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <!-- TrustBox widget - Review Collector --> <div class="trustpilot-widget" data-locale="en-GB" data-template-id="56278e9abfbbba0bdcd568bc" data-businessunit-id="5db1c65dab31570001a1caa6" data-style-height="52px" data-style-width="100%"> <a href="https://uk.trustpilot.com/review/fortnitemall.gg" target="_blank" rel="noopener">Trustpilot</a> </div> <!-- End TrustBox widget -->
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="footer-newsletter">
                    <form class="" action="{{ route('newsletter.subscribe') }}" method="post">
                        <img src="{{URL::to('/')}}/assets/images/home/footer/newsletter.png" alt="">
                        @csrf
                        <input type="email" name="email" placeholder="Please enter your E-Mail address" required>
                        <button type="submit" class="btn-newsletter">Subscribe</button>
                    </form>
                    <div class="newsletter-text">
                        <p>Enter your e-mail address above to get regularly notified about news, promotions and special offers. More information can be found in our <a href="{{route('legal.privacy')}}">privacy policy</a>.</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="payment-methods">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/cartesbancaire.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/vpay.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/americanexpress.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/cartasi.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/visa.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/mastercard.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/maestro.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/applePay.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/giropay.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/iDeal.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/sofort.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/paypal.png" alt="">
                    <img src="{{URL::to('/')}}/assets/images/home/footer/paysafecard.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="navbar-legal">
        <a href="{{route('legal.toc')}}">Terms of Service</a>
        <a href="{{route('legal.privacy')}}">Privacy Policy</a>
        <a href="{{route('legal.cookie')}}">Cookie Policy</a>
        <a href="#">Refund Policy</a>
    </div>
    <div class="navbar-copyright">
        <p>Registered Names and Trademarks are the copyright and property of their respective owners.</p>
        <p>Copyright &copy; 2019 by FortniteMall.gg. All rights reserved.</p>
        <p>Not affiliated with Epic Games.</p>
    </div>
</footer>

<script type="text/javascript">
    $(document).ready(function() {
        function scrollToObj(target, offset, time) {
    		$('html, body').animate({scrollTop: $( target ).offset().top - offset}, time);
    	}

    	$("#scrollToTop").click(function() {
    		scrollToObj('body',80, 1000);
            return false;
        });
    });
</script>
