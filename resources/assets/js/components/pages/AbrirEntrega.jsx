import React, {Component} from 'react';

class AbrirEntrega extends Component {

    constructor(props) {
        super(props);

        this.state = {
            entrega: null
        }
    }

    componentDidMount() {
        fetch(`/api/entregas/${this.props.match.params.id}`)
            .then(res => res.json())
            .then((result) => {
                this.setState({
                    entrega: result.data
                })
            })
    }

    render() {
        if (!this.state.entrega) {
            return (
                <div>
                    <i className="fa fa-spin fa-pulse fa-3x fa-fw"></i>
                    Carregando
                </div>
            )
        }

        return (
            <div></div>
        );
    }

}

export default AbrirEntrega;
