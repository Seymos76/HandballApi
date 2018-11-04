import React, { Component } from "react";
import ReactDOM from "react-dom";
import Hello from "./components/Hello";

const hello = document.getElementById('react_hello_root');

if (hello) {
    try {
        ReactDOM.render(<Hello />, hello)
    } catch (e) {
        console.error(e)
    }
}