<div id="home" style="position:relative;top:-1px;"></div>

<header class="fusion-header-wrapper">
    <div class="fusion-header-v1 fusion-logo-alignment fusion-logo-left fusion-sticky-menu- fusion-sticky-logo-1 fusion-mobile-logo-1  fusion-mobile-menu-design-modern">
        <div class="fusion-header-sticky-height"></div>
        <div class="fusion-header">
            <div class="fusion-row">
                <div class="fusion-logo" data-margin-top="10px" data-margin-bottom="20px"
                     data-margin-left="30px" data-margin-right="20px">
                    <a class="fusion-logo-link" href="https://www.chiptranz.com">

                        <!-- standard logo -->
                        <img src="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}}"
                             srcset="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}} 1x, {{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}} 2x"
                             width="310" height="106" style="max-height:106px;height:auto;"
                             alt="ChipTranz | Save and Invest in your future today Logo"
                             data-retina_logo_url="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}}"
                             class="fusion-standard-logo"/>

                        <!-- mobile logo -->
                        <img src="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}}"
                             srcset="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}} 1x, {{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}} 2x"
                             width="310" height="106" style="max-height:106px;height:auto;"
                             alt="ChipTranz | Save and Invest in your future today Logo"
                             data-retina_logo_url="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}}"
                             class="fusion-mobile-logo"/>

                        <!-- sticky header logo -->
                        <img src="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}}"
                             srcset="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}} 1x, {{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}} 2x"
                             width="310" height="106" style="max-height:106px;height:auto;"
                             alt="ChipTranz | Save and Invest in your future today Logo"
                             data-retina_logo_url="{{asset('chip-assets/images/logos/chiptranz2-logo-with-text1.png')}}"
                             class="fusion-sticky-logo"/>
                    </a>
                </div>
                <nav class="fusion-main-menu" aria-label="Main Menu">
                    <ul id="menu-chiptranz-main-menu" class="fusion-menu">
                        <li id="menu-item-803"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-9 current_page_item menu-item-803"
                            data-item-id="803"><a href="{{url('/')}}"
                                                  class="fusion-bar-highlight"><span
                                        class="menu-text">Home</span></a></li>
                        <li id="menu-item-800"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-800 fusion-dropdown-menu"
                            data-item-id="800"><a href="#" class="fusion-bar-highlight"><span class="menu-text">Savings Solution</span>
                                <span class="fusion-caret"><i class="fusion-dropdown-indicator"></i></span></a>
                            <ul role="menu" class="sub-menu">
                                <li id="menu-item-873"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-873 fusion-dropdown-submenu">
                                    <a href="{{url('/solution#youth')}}"
                                       class="fusion-bar-highlight avada-noscroll"><span>Youths Goals</span></a></li>
                                <li id="menu-item-874"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-874 fusion-dropdown-submenu">
                                    <a href="{{url('/solution#steady')}}"
                                       class="fusion-bar-highlight avada-noscroll"><span>Steady Growth</span></a></li>
                            </ul>
                        </li>
                        
                        <li id="menu-item-866"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-866"
                            data-item-id="866"><a href="{{url('/faq')}}"
                                                  class="fusion-bar-highlight"><span
                                        class="menu-text">FAQs</span></a></li>
                        @guest
                        <li id="menu-item-880"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-880 fusion-menu-item-button"
                            data-item-id="880"><a href="{{ route('login') }}"
                                                  class="fusion-bar-highlight"><span
                                        class="menu-text fusion-button button-default button-small">Sign in</span></a>
                        </li>
                            <li id="menu-item-880"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-880 fusion-menu-item-button"
                            data-item-id="880"><a href="{{ route('register') }}"
                                                  class="fusion-bar-highlight"><span
                                        class="menu-text fusion-button button-default button-small">Sign up</span></a>
                        </li>
                        @else
                            <li id="menu-item-866"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-866"
                                data-item-id="866"><a href="{{url('/home')}}"
                                                      class="fusion-bar-highlight"><span
                                            class="menu-text fusion-button button-default button-small">My Account</span></a></li>
                            <li id="menu-item-880"
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-880 fusion-menu-item-button"
                                data-item-id="880">
                                <a class="fusion-bar-highlight" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                   <span
                                           class="menu-text fusion-button button-default button-small">Sign out</span>

                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </li>


                        @endguest
                    </ul>
                </nav>
                <div class="fusion-mobile-menu-icons">
                    <a href="#" class="fusion-icon fusion-icon-bars" aria-label="Toggle mobile menu"
                       aria-expanded="false"></a>


                </div>

                <nav class="fusion-mobile-nav-holder fusion-mobile-menu-text-align-left fusion-mobile-menu-indicator-hide"
                     aria-label="Main Menu Mobile"></nav>

            </div>
        </div>
    </div>
    <div class="fusion-clearfix"></div>
</header>


<div id="sliders-container">
</div>


<div class="avada-page-titlebar-wrapper">
    @yield('page-title')
</div>