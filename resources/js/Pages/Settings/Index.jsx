import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import { Head } from "@inertiajs/inertia-react";
import General from "@/Components/Settings/General.jsx";
import Password from "@/Components/Settings/Password.jsx";

export default function Index(props) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Settings
                </h2>
            }
        >
            <Head title="Settings" />

            <div className="grid grid-cols-1 gap-4 py-10 lg:grid-cols-2">
                <div>
                    <General />
                </div>
                <div>
                    <Password />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
