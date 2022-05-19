/**
 * Custom Functions
 * 
 * @author MMK Jony <mmkjony@gmail.com>
 */

// function for leading 0, (optional)
function zeroPadding(num, digit) {
    var zero = '';
    for(var i = 0; i < digit; i++) {
        zero += '0';
    }
    return (zero + num).slice(-digit);
}


/**
 * Custom Classes, for Vue
 * 
 * @author MMK Jony <mmkjony@gmail.com>
 */

/**
 * Error Handler Class
 */
class Errors {
    // Create a new Errors instance.
    constructor() {
        this.errors = {};
    }

    // Checks if an errors exists for the given field, (string)
    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    // Checks if we have any errors
    any() {
        return Object.keys(this.errors).length > 0;
    }

    // Get the error message for a field, (string)
    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    // Add new error, (object)
    record(errors) {
        this.errors = errors;
    }

    // Clear one or all error fields, (string|null)
    clear(field) {
        if (field) {
            delete this.errors[field];

            return;
        }

        this.errors = {};
    }
} // End of class Errors


/**
 * Form Handler Class
 */
class Form {
    // Create a new Form instance, (object - form data)
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    // Fetch all field data for the form
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    // Reset form fields, and clear errors
    reset() {
        for (let field in this.originalData) {
            this[field] = this.originalData[field];
        }

        this.errors.clear();
    }

    // Send a POST request to the given URL, (string - route)
    post(url) {
        return this.submit('post', url);
    }

    // Send a GET request to the given URL, (string - route)
    get(url) {
        return this.submit('get', url);
    }

    // Send a PUT request to the given URL, (string - route)
    put(url) {
        return this.submit('put', url);
    }

    // Send a PATCH request to the given URL, (string - route)
    patch(url) {
        return this.submit('patch', url);
    }

    // Send a DELETE request to the given URL, (string - route)
    delete(url) {
        return this.submit('delete', url);
    }

    /**
     * Submit the form with axios.
     *
     * @param {string} requestType - post, put, patch, delete
     * @param {string} url - route
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data);

                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response.data);

                    reject(error.response.data);
                });
        });
    }

    // Handle a successful form submission, (object - response data)
    onSuccess(data) {
        // alert(data.message);

        // this.reset();
        this.errors.clear();
    }

    // Handle a failed form submission, (object - response errors data)
    onFail(errors) {
        this.errors.record(errors);
    }
} // End of class Form