export class EntregaService {
    static all() {
        return fetch("/api/entregas")
            .then(res => res.json())
    }

    static find(id) {
        return fetch(`/api/entregas/${id}`)
            .then(res => res.json())
    }

    static create(formData) {
        return fetch("/api/entregas", {
            method: 'POST',
            body: JSON.stringify(formData)
        })
    }
}
