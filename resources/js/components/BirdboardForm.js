class BirdboardForm {
    constructor(data){
        this.originalData = {};

        this.originalData = JSON.parse(JSON.stringify(data))

        Object.assign(this, data);

        this.errors = {};
        this.submitted = false;
    }

    data(){

        Object.keys(this.originalData).reduce((data, attribute) =>{
            data[attribute] = this[attribute];
        }, {});

        // let data = {};
        //
        // for(let attribute in this.originalData){
        //     data[attribute] = this[attribute]
        // }
        //
        return data;
    }

    submit(endpoint){
        return axios.post(endpoint, this.data())
            .catch(this.onFail.bind(this))
            .then(this.onSuccess.bind(this));
    }

    post(endpoint){
        this.submit(endpoint);
    }

    patch(endpoint){
        this.submit(endpoint, 'patch');
    }

    delete(endpoint){
        this.submit(endpoint, 'patch');
    }

    onSuccess(endpoint){
        this.submitted = true;
        this.errors = {}

        return response;
    }

    onFail(error){
        this.errors = error.response.data.errors;
        this.submitted = false;

        throw error;
    }

    reset(){
        Object.assign(this, this.originalData);
    }
}

export default BirdboardForm;
