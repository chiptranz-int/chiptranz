import React from 'react';
import ReactDOM from 'react-dom';
import  Views  from './Views';
import  {Router, Route, Link} from 'react-router-dom';




function Web() {
    return (
        <div className="container">
        </div>
    );
}

export default Web;

if (document.getElementById('main')) {
    ReactDOM.render(<Views />, document.getElementById('main'));
}


