import React from "react";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import InputError from "@/Components/InputError.jsx";
import { useForm, usePage } from "@inertiajs/inertia-react";

export default function Password() {
    const form = useForm({
        password: "",
        password_confirmation: "",
    });

    const submit = (e) => {
        e.preventDefault();

        form.post(route("settings.password"), {
            onSuccess: () => {
                form.reset();
            },
        });
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow">
            <form onSubmit={submit}>
                <div>
                    <label htmlFor="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        value={form.data.password}
                        onChange={(e) =>
                            form.setData("password", e.target.value)
                        }
                        required
                    />
                    <InputError
                        className="mt-2"
                        message={form.errors.password}
                    />
                </div>

                <div className="my-4">
                    <label htmlFor="password">Password Confirmation</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        value={form.data.password_confirmation}
                        onChange={(e) =>
                            form.setData(
                                "password_confirmation",
                                e.target.value
                            )
                        }
                        required
                    />
                    <InputError
                        className="mt-2"
                        message={form.errors.password_confirmation}
                    />
                </div>

                <div className="text-right">
                    <PrimaryButton processing={form.processing}>
                        Update
                    </PrimaryButton>
                </div>
            </form>
        </div>
    );
}
