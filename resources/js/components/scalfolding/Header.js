/**
 * Created by MoFoLuWaSo on 9/3/2019.
 */
import React, { Component } from 'react';


class Header extends Component{


toggleSideBar(){
   //document.querySelector("body").classList.toggle("sidebar-icon-only");
}

toggleRightSideBar(){
    document.querySelector("#sidebar").classList.toggle("active");
}


logout(){
    document.querySelector("#logout-form").submit();
}

    render(){
        return (


            <div>
                <nav className="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-primary">
                    <div className="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a className="navbar-brand brand-logo" href="/home"><img src={`../../chiptranz-vendors/images/logo.svg`} alt="logo"/></a>
                        <a className="navbar-brand brand-logo-mini" href="/home"><img src={`../../chiptranz-vendors/images/logo-mini.svg`} alt="logo"/></a>
                    </div>
                    <div className="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                        <button className="navbar-toggler navbar-toggler align-self-center d-none" onClick={this.toggleSideBar} type="button" data-toggle="minimize">
                            <span className="mdi mdi-menu"></span>
                        </button>
                        <ul className="navbar-nav navbar-nav-right">


                            <li className="nav-item nav-profile dropdown">
                                <a className="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                                    <img src={`../../chiptranz-vendors/images/placeholder.jpg`} alt="profile"/>
                                </a>

                            </li>
                            <li className="nav-item nav-settings d-none d-lg-block">
                                <a className="nav-link" data-toggle="tooltip"  data-placement="bottom" title="Sign Out" onClick={this.logout}>
                                    <i className="mdi mdi-logout"></i>
                                </a>
                            </li>
                        </ul>
                        <button className="navbar-toggler navbar-toggler-right d-lg-none align-self-center" onClick={this.toggleRightSideBar}
                                type="button" data-toggle="offcanvas">
                            <span className="mdi mdi-menu"></span>
                        </button>
                    </div>
                </nav>

            </div>

        );
    }
}

export default Header;