import React, {Component} from 'react';
import {Link} from "react-router-dom";

class IndexEntrega extends Component {

    constructor(props) {
        super(props);
        this.state = {
            entregas: [],
            entregas_filtradas: []
        };

        this.handleSearch = this.handleSearch.bind(this);
    }

    componentDidMount() {
        fetch("/api/entregas")
            .then(res => res.json())
            .then((result) => {
                this.setState({
                    entregas: result.data,
                    entregas_filtradas: result.data
                })
            })
    }

    handleSearch(e) {
        this.setState({
            entregas_filtradas: this.state.entregas.filter((item) => {
                return item.cliente.indexOf(e.target.value) >= 0;
            })
        });
    }

    render() {
        return (
            <div>
                <div className="row">
                    <div className="col-9">
                        <h3>Entregas</h3>
                    </div>
                    <div className="col-3 text-right">
                        <Link to={'/nova'} className='btn btn-dark'>
                    <span className="fa fa-plus">
                    </span>
                            &nbsp;Nova Entrega
                        </Link>
                    </div>
                </div>

                <div className="row mt-3">
                    <div className="col-12">
                        <input type='text' onKeyUp={this.handleSearch} className="form-control" placeholder="Buscar por Cliente"/>
                    </div>
                </div>

                <div className="row">
                    {this.state.entregas_filtradas.length > 0 ? this.state.entregas_filtradas.map((item) => (
                        <div className="col-sm-4 col-12 mt-4" key={item.id}>
                            <div className="card card-default">
                                <div className="card-body">
                                    <div className="row">
                                        <div className="col-6">
                                            <small>Cliente</small>
                                            <p>{item.cliente}</p>
                                        </div>
                                        <div className="col-6">
                                            <small>Data de Entrega</small>
                                            <p>{item.data_entrega}</p>
                                        </div>
                                    </div>

                                    <Link to={`/abrir/${item.id}`}>Ver no Mapa</Link>
                                </div>
                            </div>
                        </div>
                    )) : (
                        <div className="col-12 mt-4">
                            <div className="alert alert-info">
                                Nenhum registro encontrado.
                            </div>
                        </div>
                    )}
                </div>
            </div>
        );
    }
}

export default IndexEntrega;
