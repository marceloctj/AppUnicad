import React, {Component} from 'react';
import {Link, Redirect} from "react-router-dom";

class CreateEntrega extends Component {

    constructor(props) {
        super(props);

        this.state = {
            cliente: '',
            data_entrega: '',
            endereco_origem: '',
            endereco_destino: '',
            errorBag: {}
        };

        this.handleReset = this.handleReset.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleInputChange(e) {
        this.setState({
            [e.target.name]: e.target.value
        });
    };

    handleSubmit(e) {
        e.preventDefault();

        const formData = {
            cliente: this.state.cliente,
            data_entrega: this.state.data_entrega,
            endereco_origem: this.state.endereco_origem,
            endereco_destino: this.state.endereco_destino
        };

        fetch("/api/entregas", {
            method: 'POST',
            body: JSON.stringify(formData)
        }).then((response) => {

            response.json().then((responseJson) => {
                if(response.ok) {
                    alert("Entrega cadastrada com sucesso!");
                    this.handleReset();
                    this.props.history.push('/');
                } else {
                    this.setState({
                        errorBag: responseJson.errors
                    })
                }
            });
        });
    };

    handleReset() {
        this.setState({
            cliente: '',
            data_entrega: '',
            endereco_origem: '',
            endereco_destino: '',
            errorBag: {}
        });
    };

    render() {
        return (
            <div>
                <div className="pull-left">
                    <Link to={'/'} className='btn btn-dark btn-sm'>
                        <span className="fa fa-arrow-left"></span>
                    </Link>
                </div>
                <h3 className="pull-left ml-3">Nova Entrega</h3>

                <div className="clearfix"></div>

                <div className="card mt-2">
                    <div className="card-body">
                        <div className={`form-group row ${this.hasValidador('cliente') ? 'has-error' : ''}`}>
                            <label htmlFor="inputCliente" className="col-sm-2 col-form-label required">
                                Nome do Cliente</label>
                            <div className="col-sm-6">
                                <input type="text" className="form-control" id="inputCliente"
                                       placeholder="Nome do Cliente" name="cliente" onChange={this.handleInputChange}
                                       value={this.state.cliente}/>

                                {this.handleValidators('cliente')}
                            </div>
                        </div>
                        <div className={`form-group row ${this.hasValidador('data_entrega') ? 'has-error' : ''}`}>
                            <label htmlFor="inputDataEntrega" className="col-sm-2 col-form-label required">
                                Data de Entrega</label>
                            <div className="col-sm-6">
                                <input type="date" className="form-control" id="inputDataEntrega"
                                       placeholder="dd/mm/YYYY" name="data_entrega" onChange={this.handleInputChange}
                                       value={this.state.data_entrega}/>
                                {this.handleValidators('data_entrega')}
                            </div>
                        </div>
                        <div className={`form-group row ${this.hasValidador('endereco_origem') ? 'has-error' : ''}`}>
                            <label htmlFor="inputCliente" className="col-sm-2 col-form-label required">
                                Endereço de Partida</label>
                            <div className="col-sm-6">
                                <input type="text" className="form-control" id="inputCliente"
                                       placeholder="Endereço de Partida" name="endereco_origem"
                                       onChange={this.handleInputChange} value={this.state.endereco_origem}/>
                                {this.handleValidators('endereco_origem')}
                            </div>
                        </div>
                        <div className={`form-group row ${this.hasValidador('endereco_destino') ? 'has-error' : ''}`}>
                            <label htmlFor="inputCliente" className="col-sm-2 col-form-label required">
                                Endereço de Destino</label>
                            <div className="col-sm-6">
                                <input type="text" className="form-control" id="inputCliente"
                                       placeholder="Endereço de Destino" name="endereco_destino"
                                      onChange={this.handleInputChange} value={this.state.endereco_destino}/>
                                {this.handleValidators('endereco_destino')}
                            </div>
                        </div>
                    </div>
                    <div className="card-footer">
                        <button className="btn btn-primary" onClick={this.handleSubmit}>
                            Cadastrar
                        </button>
                        <button className="btn btn-secondary ml-3" onClick={this.handleReset}>
                            Reset
                        </button>
                    </div>
                </div>

            </div>
        );
    }

    handleValidators(input = '') {

        if(this.hasValidador(input)) {
            return (
                <div className="invalid-feedback">
                    {this.state.errorBag[input].join('<br>')}
                </div>
            );
        }

        return '';
    }

    hasValidador(input = '') {
        return this.state.errorBag.hasOwnProperty(input);
    }
}

export default CreateEntrega;
