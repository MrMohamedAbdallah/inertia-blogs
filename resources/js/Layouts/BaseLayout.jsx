import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import ApplicationLogo from "@/Components/ApplicationLogo.jsx";
import { Link, usePage } from "@inertiajs/inertia-react";

export default function BaseLayout({ children }) {
    const props = usePage().props;

    return (
        <>
            {props.auth.user ? (
                <AuthenticatedLayout>{children}</AuthenticatedLayout>
            ) : (
                <div className="bg-gray-100">
                    <nav className="bg-white border-b border-gray-100">
                        <div className="container">
                            <div className="flex items-center justify-between h-16">
                                <div className="flex items-center shrink-0">
                                    <Link href="/">
                                        <ApplicationLogo className="block w-auto h-9" />
                                    </Link>
                                </div>
                                <div>
                                    <Link
                                        href={route("login")}
                                        className="text-sm text-gray-700 underline dark:text-gray-500"
                                    >
                                        Log in
                                    </Link>

                                    <Link
                                        href={route("register")}
                                        className="ml-4 text-sm text-gray-700 underline dark:text-gray-500"
                                    >
                                        Register
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </nav>

                    <main className="container">{children}</main>
                </div>
            )}
        </>
    );
}
