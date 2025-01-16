import {logout} from './../services/auth.server'
import {redirect} from "@remix-run/react";

export let action = async ({request}) => {
    return logout({request});
};

export let loader = async () => {
    return redirect("/");
};