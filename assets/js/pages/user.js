// ES6 Modules
// --------------------
import '../../app.js';

// SASS files
// --------------------
import '../../scss/pages/user.scss';
import '../../scss/components/izitoast.scss';
import '../../scss/components/table.scss';

// DOM Elements
// --------------------

class User {

    constructor(options) {

        let defaults = {};

        let _options = {...defaults, ...options};

    }

    init() {

    }

}

let _User = new User();
_User.init();