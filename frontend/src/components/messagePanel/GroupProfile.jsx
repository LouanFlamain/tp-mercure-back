import Profile from "../leftPanel/Profile";

const GroupProfile = () => {
  return (
    <div className="bg-dark w-full h-16 p-4 flex items-center rounded-tr-2xl">
      <Profile />
      <p>Group Name</p>
    </div>
  );
};

export default GroupProfile;
