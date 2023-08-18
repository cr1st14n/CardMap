
const path = require('path');
const express = require('express');
const axios = require('axios');
const app = express();
app.use(express.json());


const http = require('http').createServer(app);
const io = require('socket.io')(http, {
    cors: {
        origin: '*', // Aquí puedes cambiar el dominio permitido, o '*' para permitir todos los dominios.
        methods: ['GET', 'POST'],
        allowedHeaders: ['my-custom-header'],
        credentials: true
    }
});

// Resto de tu código...
io.on('connection', (socket) => {
    console.log('New connection', socket.id);

    socket.on('chat:message', (data) => {
        console.log(data);
        io.emit('chat:message', data);
    });

    socket.on('chat:typing', (data) => {
        socket.broadcast.emit('chat:typing', data);
    });
});
// Inicia el servidor en el puerto 3000
http.listen(3009, () => {
    console.log('Server listening on port 3009');
});

// api para recepcionar datos del ARDUINO
app.get('/api/access_verificacion/:area/:codigo', async (req, res) => {
    const area = req.params.area;
    const codigo = req.params.codigo;
    console.log(area + '|' + codigo);
    const query = await axios.get('http://localhost/creden/api/access_verificacion?codigo=' + codigo + '&area=' + area);
    console.log(query.data);
    console.log(query.data.message);
    io.emit('lectura:lec_tarjeta', query.data);
    res.status(200).json({ estado: query.status, message: query.message });
});  