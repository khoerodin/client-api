const express = require('express')
const router = express.Router()
const unirest = require('unirest')

router.post('/', function (req, res, next) {
  const authData = {
    username: req.body.email,
    password: req.body.password,
    grant_type: 'password',
    client_id: process.env.CLIENT_ID,
    client_secret: process.env.CLIENT_SECRET
  }

  unirest.post(process.env.TOKEN_URL)
  .send(authData)
  .end(function (response) {
    if(response.body.error && authData.client_secret && authData.client_id && authData.grant_type) {
      res.json({error: 'error', message: 'Your data did not match. Please double-check and try again.'})
    } else {
      res.json(response.body)
    }
  })
})

module.exports = router
