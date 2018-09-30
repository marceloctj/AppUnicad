import React, {Component} from 'react';
import { withScriptjs, withGoogleMap, GoogleMap, DirectionsRenderer } from "react-google-maps"
import {compose, withProps, lifecycle} from 'recompose';
import {Link} from "react-router-dom";
import {EntregaService} from "../../../services/entrega.service";

const MAPS_KEY = 'AIzaSyB5hXWwp5vU5CTEyQlmw56y65oyD5Z-jqQ';
const MAPS_URL = `https://maps.googleapis.com/maps/api/geocode/json`;

const MapWithADirectionsRenderer = compose(
    withProps({
        googleMapURL: `https://maps.googleapis.com/maps/api/js?key=${MAPS_KEY}&v=3.exp&libraries=geometry,drawing,places`,
        loadingElement: <div style={{ height: `100%` }} />,
        containerElement: <div style={{ height: `400px` }} />,
        mapElement: <div style={{ height: `100%` }} />,
    }),
    withScriptjs,
    withGoogleMap,
    lifecycle({
        componentDidMount() {

            const DirectionsService = new google.maps.DirectionsService();

            DirectionsService.route({
                origin: new google.maps.LatLng(this.props.origem.lat, this.props.origem.lng),
                destination: new google.maps.LatLng(this.props.destino.lat, this.props.destino.lng),
                travelMode: google.maps.TravelMode.DRIVING,
            }, (result, status) => {
                if (status === google.maps.DirectionsStatus.OK) {
                    this.setState({
                        directions: result,
                    });
                } else {
                    console.error(`error fetching directions ${result}`);
                }
            });
        }
    })
)(props =>
    <GoogleMap
        defaultZoom={7}>
        {props.directions && <DirectionsRenderer directions={props.directions} />}
    </GoogleMap>
);

class AbrirEntrega extends Component {

    constructor(props) {
        super(props);

        this.state = {
            entrega: null,
            origem: null,
            destino: null
        }
    }

    getGeocodeInfo(endereco) {
        return fetch(`${MAPS_URL}?address=${endereco}&key=${MAPS_KEY}`)
            .then(res => res.json())
    }

    componentDidMount() {

        EntregaService.find(this.props.match.params.id)
            .then((result) => {
                this.setState({
                    entrega: result.data
                });

                this.getGeocodeInfo(result.data.endereco_origem)
                    .then((response) => {
                        if(response.status === 'OK') {
                            this.setState({
                                origem: response.results[0].geometry.location
                            });
                        }
                    });

                this.getGeocodeInfo(result.data.endereco_destino)
                    .then((response) => {
                        if(response.status === 'OK') {
                            this.setState({
                                destino: response.results[0].geometry.location
                            })
                        }
                    });
            });
    }

    render() {
        if (!this.state.entrega) {
            return (
                <div>
                    <i className="fa fa-spin fa-pulse fa-3x fa-fw"/>
                    Carregando
                </div>
            )
        }

        return (
            <div>
                <div className="pull-left">
                    <Link to={'/'} className='btn btn-dark btn-sm'>
                        <span className="fa fa-arrow-left"></span>
                    </Link>
                </div>
                <h3 className="pull-left ml-3">Entrega #{this.state.entrega.id}</h3>

                <div className="clearfix"></div>

                <div className="row">
                    <div className="col-12 col-sm-3">
                        <small>Nome do Cliente</small><br/>
                        <p>{this.state.entrega.cliente}</p>
                    </div>
                    <div className="col-12 col-sm-3">
                        <small>Data de Entrega</small><br/>
                        <p>{this.state.entrega.data_entrega}</p>
                    </div>
                </div>
                <div className="row">
                    <div className="col-12">
                        <small>Endereço de Partida</small><br/>
                        <p>{this.state.entrega.endereco_origem}</p>
                    </div>
                    <div className="col-12">
                        <small>Endereço de Destino</small><br/>
                        <p>{this.state.entrega.endereco_destino}</p>
                    </div>
                </div>

                {this.state.destino && this.state.origem ? (
                    <MapWithADirectionsRenderer origem={this.state.origem} destino={this.state.destino}/>
                ) : (
                    <div className="overlay">
                        <div className="overlay-content">
                            <i className="fa fa-spinner fa-pulse fa-3x fa-fw"/>
                            <p>Carregando</p>
                        </div>
                    </div>
                )}
            </div>
        );
    }

}

export default AbrirEntrega;
