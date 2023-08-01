// const path = require('path');
// const express = require('express');
// const app = express();

// // Importa el paquete cors
// const cors = require('cors');

// app.use(express.json());

// app.set('port', process.env.PORT || 3000);

// console.log(path.join(__dirname, 'public'));
// app.use(express.static(path.join(__dirname, 'public')));

// // Agrega el middleware cors para habilitar CORS
// app.use(cors());

// const server = app.listen(app.get('port'), () => {
//     console.log('Server on', app.get('port'));
// });

// const SocketIO = require('socket.io');
// const io = SocketIO(server);

// io.on('connection', (socket) => {
//     console.log('New connection', socket.id);

//     socket.on('chat:message', (data) => {
//         console.log(data);
//         io.emit('chat:message', data);
//     });

//     socket.on('chat:typing', (data) => {
//         socket.broadcast.emit('chat:typing', data);
//     });
// });

// Importa las siguientes bibliotecas
const path = require('path');
const express = require('express');
const axios = require('axios');
const app = express();
app.use(express.json());


const http = require('http').createServer(app);
const io = require('socket.io')(http, {
    cors: {
        origin: 'http://localhost', // Aquí puedes cambiar el dominio permitido, o '*' para permitir todos los dominios.
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
http.listen(3000, () => {
    console.log('Server listening on port 3000');
});

// api para recepcionar datos del ARDUINO
app.post('/api/access_verificacion', async (req, res) => {
    const message = req.body;
    const data = { codigo: message.codigo, accesso: message.area };
    const query = await axios.get('http://localhost/creden/api/access_verificacion?codigo=' + message.codigo + '&area=' + message.area);
    console.log(query.data);
    io.emit('lectura:lec_tarjeta', query.data);
    res.status(200).json({ success: true, message: 'Message sent successfully' });
});