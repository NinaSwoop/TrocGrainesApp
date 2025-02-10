// import {useContext} from "react";
// import {AuthContext} from "../context/AuthContext.tsx";
import ProfileCard from "../components/ProfileCard.tsx";

export default function Profile() {
    // const { user } = useContext(AuthContext);

    return (
        <div className="flex flex-col bg-gray-100 pt-[5rem] lg:pt-[5rem]">
            <div className="flex items-center justify-center p-10">
                <ProfileCard />
            </div>
        </div>
    );
}